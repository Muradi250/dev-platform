<?php

namespace App\Services\Translations;

use App\Contracts\TranslationProvider;
use Illuminate\Support\Facades\Http;
use RuntimeException;
use Throwable;

class OpenAITranslationProvider implements TranslationProvider
{
    protected string $endpoint = 'https://api.openai.com/v1/responses';

    public function translate(
        array $data,
        string $sourceLocale,
        string $targetLocale,
        string $context = ''
    ): array {
        if (empty($data)) {
            return [];
        }

        $apiKey = config('services.openai.api_key');

        if (empty($apiKey)) {
            throw new RuntimeException(
                'OpenAI API key is not configured.'
            );
        }

        $model = config(
            'services.openai.translation_model',
            'gpt-5.6-luna'
        );

        $sourceLanguage = $this->languageName($sourceLocale);
        $targetLanguage = $this->languageName($targetLocale);

        $systemPrompt = implode("\n", [
            'You are a professional multilingual website translator.',
            'Translate human-readable website content only.',
            'Preserve the exact JSON structure and keys.',
            'Return only valid JSON.',
            'Do not add, remove, rename, or reorder fields.',
            'Do not translate brand names, product names, person names, company names, technical identifiers, or proper nouns unless the source clearly uses a translatable descriptive phrase.',
            'Preserve URLs, paths, codes, numbers, symbols, and technical values exactly.',
            'Preserve line breaks where possible.',
            'Keep the meaning natural and professional for a modern organization management platform.',
            'Do not add explanations or markdown.',
            'Source language: ' . $sourceLanguage,
            'Target language: ' . $targetLanguage,
            $context !== ''
                ? 'Context: ' . $context
                : '',
        ]);

        $payload = [
            'model' => $model,

            /*
             * Do not persist conversation state for this translation request.
             */
            'store' => false,

            'input' => [
                [
                    'role' => 'system',
                    'content' => [
                        [
                            'type' => 'input_text',
                            'text' => $systemPrompt,
                        ],
                    ],
                ],
                [
                    'role' => 'user',
                    'content' => [
                        [
                            'type' => 'input_text',
                            'text' => json_encode(
                                $data,
                                JSON_UNESCAPED_UNICODE
                                | JSON_UNESCAPED_SLASHES
                                | JSON_PRETTY_PRINT
                            ),
                        ],
                    ],
                ],
            ],

            /*
             * Structured JSON output.
             *
             * The schema intentionally allows arbitrary nested JSON
             * because different blocks have different structures.
             *
             * PageBlockTranslationService remains the final security
             * boundary and accepts only explicitly mapped fields.
             */
            'text' => [
                'format' => [
                    'type' => 'json_schema',
                    'name' => 'translated_block_data',
                    'description' => 'Translated website block data.',
                    'schema' => [
                        'type' => 'object',
                        'additionalProperties' => true,
                    ],
                    'strict' => false,
                ],
            ],
        ];

        try {
            $response = Http::timeout(
                (int) config(
                    'services.openai.translation_timeout',
                    90
                )
            )
                ->retry(
                    2,
                    500,
                    throw: false
                )
                ->withToken($apiKey)
                ->acceptJson()
                ->post(
                    $this->endpoint,
                    $payload
                );

            if ($response->failed()) {
                throw new RuntimeException(
                    'OpenAI translation request failed. '
                    . 'HTTP ' . $response->status()
                    . ': ' . $response->body()
                );
            }

            $responseData = $response->json();

            $outputText = $this->extractOutputText(
                $responseData
            );

            if ($outputText === null) {
                throw new RuntimeException(
                    'OpenAI returned no output text.'
                );
            }

            $translated = json_decode(
                $outputText,
                true
            );

            if (! is_array($translated)) {
                throw new RuntimeException(
                    'OpenAI returned invalid translation JSON.'
                );
            }

            return $translated;

        } catch (Throwable $e) {
            throw new RuntimeException(
                'Translation provider error: '
                . $e->getMessage(),
                previous: $e
            );
        }
    }

    /**
     * Extract output text from the Responses API response.
     */
    protected function extractOutputText(
        array $responseData
    ): ?string {
        $output = $responseData['output'] ?? null;

        if (! is_array($output)) {
            return null;
        }

        foreach ($output as $outputItem) {
            if (
                ! is_array($outputItem)
                || ($outputItem['type'] ?? null) !== 'message'
            ) {
                continue;
            }

            $content = $outputItem['content'] ?? [];

            if (! is_array($content)) {
                continue;
            }

            foreach ($content as $contentItem) {
                if (
                    is_array($contentItem)
                    && ($contentItem['type'] ?? null) === 'output_text'
                ) {
                    $text = $contentItem['text'] ?? null;

                    if (is_string($text) && $text !== '') {
                        return $text;
                    }
                }
            }
        }

        return null;
    }

    /**
     * Convert locale codes into clear language names
     * for the translation prompt.
     */
    protected function languageName(
        string $locale
    ): string {
        return match ($locale) {
            'en' => 'English',
            'fa' => 'Persian (Farsi)',
            'ps' => 'Pashto',
            'ar' => 'Arabic',
            'tr' => 'Turkish',
            'ur' => 'Urdu',
            default => $locale,
        };
    }
}
