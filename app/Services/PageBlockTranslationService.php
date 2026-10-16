<?php

namespace App\Services;

use App\Models\PageBlock;

class PageBlockTranslationService
{
    /**
     * Fields that contain human-readable content
     * and are safe to send to a translation provider.
     *
     * URLs, file paths, icons, colors, numbers, booleans,
     * layout settings and technical values are intentionally excluded.
     */
    protected array $translatableFields = [

        /*
        |--------------------------------------------------------------------------
        | Hero
        |--------------------------------------------------------------------------
        */

        'hero' => [
            'eyebrow',
            'badge',
            'title',
            'highlight',
            'description',
            'primary_button_text',
            'secondary_button_text',
        ],

        /*
        |--------------------------------------------------------------------------
        | Text
        |--------------------------------------------------------------------------
        */

        'text' => [
            'badge',
            'heading',
            'content',
            'button_text',
        ],

        /*
        |--------------------------------------------------------------------------
        | Image
        |--------------------------------------------------------------------------
        */

        'image' => [
            'alt',
            'title',
            'description',
            'caption',
        ],

        /*
        |--------------------------------------------------------------------------
        | Gallery
        |--------------------------------------------------------------------------
        */

        'gallery' => [
            'title',
            'description',
            'images.*.title',
            'images.*.alt',
            'images.*.description',
            'images.*.caption',
        ],

        /*
        |--------------------------------------------------------------------------
        | Cards
        |--------------------------------------------------------------------------
        */

        'cards' => [
            'title',
            'description',
            'cards.*.title',
            'cards.*.description',
            'cards.*.button_text',
        ],

        /*
        |--------------------------------------------------------------------------
        | Features
        |--------------------------------------------------------------------------
        */

        'features' => [
            'eyebrow',
            'title',
            'description',
            'features.*.title',
            'features.*.badge',
            'features.*.description',
        ],

        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        'statistics' => [
            'title',
            'statistics.*.label',
        ],

        /*
        |--------------------------------------------------------------------------
        | CTA
        |--------------------------------------------------------------------------
        */

        'cta' => [
            'eyebrow',
            'title',
            'description',
            'button_text',
            'secondary_button_text',
            'badge',
        ],

        /*
        |--------------------------------------------------------------------------
        | FAQ
        |--------------------------------------------------------------------------
        */

        'faq' => [
            'eyebrow',
            'title',
            'description',
            'questions.*.question',
            'questions.*.badge',
            'questions.*.answer',
        ],

        /*
        |--------------------------------------------------------------------------
        | Team
        |--------------------------------------------------------------------------
        */

        'team' => [
            'eyebrow',
            'title',
            'description',
            'members.*.position',
            'members.*.department',
            'members.*.bio',
        ],

        /*
        |--------------------------------------------------------------------------
        | Testimonials
        |--------------------------------------------------------------------------
        */

        'testimonials' => [
            'title',
            'description',
            'testimonials.*.position',
            'testimonials.*.content',
            'form.success_message',
            'form.pending_message',
        ],

        /*
        |--------------------------------------------------------------------------
        | Video
        |--------------------------------------------------------------------------
        */

        'video' => [
            'title',
            'description',
        ],

        /*
        |--------------------------------------------------------------------------
        | Contact
        |--------------------------------------------------------------------------
        */

        'contact' => [
            'title',
            'description',
            'working_hours',
            'social_links.*.label',
        ],

        /*
        |--------------------------------------------------------------------------
        | HTML
        |--------------------------------------------------------------------------
        |
        | Raw HTML is intentionally excluded.
        |
        */

        'html' => [],

        /*
        |--------------------------------------------------------------------------
        | Divider
        |--------------------------------------------------------------------------
        */

        'divider' => [],

        /*
        |--------------------------------------------------------------------------
        | Logo Cloud
        |--------------------------------------------------------------------------
        */

        'logo_cloud' => [
            'title',
            'description',
        ],

        /*
        |--------------------------------------------------------------------------
        | Pricing
        |--------------------------------------------------------------------------
        */

        'pricing' => [
            'badge',
            'title',
            'description',
            'plans.*.name',
            'plans.*.badge',
            'plans.*.description',
            'plans.*.period',
            'plans.*.features.*.feature',
            'plans.*.button_text',
        ],

        /*
        |--------------------------------------------------------------------------
        | Timeline
        |--------------------------------------------------------------------------
        */

        'timeline' => [
            'title',
            'description',
            'steps.*.title',
            'steps.*.description',
            'steps.*.duration',
            'steps.*.label',
        ],
    ];

    /**
     * Return the translatable field definitions
     * for a specific PageBlock.
     */
    public function getTranslatableFields(PageBlock $block): array
    {
        return $this->translatableFields[$block->type] ?? [];
    }

    /**
     * Determine whether this block type is supported
     * by the translation system.
     */
    public function supports(PageBlock $block): bool
    {
        return array_key_exists(
            $block->type,
            $this->translatableFields
        );
    }

    /**
     * Extract only the human-readable fields that are
     * allowed to be translated.
     *
     * The original block data is never modified.
     */
    public function extractTranslatableData(PageBlock $block): array
    {
        $data = is_array($block->data)
            ? $block->data
            : [];

        $fields = $this->getTranslatableFields($block);

        if (empty($fields)) {
            return [];
        }

        $result = [];

        foreach ($fields as $path) {
            $segments = explode('.', $path);

            $this->extractPath(
                $data,
                $result,
                $segments
            );
        }

        return $result;
    }

    /**
     * Apply translated values only to fields that are
     * explicitly allowed by the mapping.
     *
     * The original block structure is preserved.
     *
     * Any translated data outside the allowed mapping
     * is ignored.
     */
    public function applyTranslations(
        PageBlock $block,
        array $translatedData
    ): array {
        $originalData = is_array($block->data)
            ? $block->data
            : [];

        $fields = $this->getTranslatableFields($block);

        if (empty($fields)) {
            return $originalData;
        }

        foreach ($fields as $path) {
            $segments = explode('.', $path);

            $this->applyPath(
                $originalData,
                $translatedData,
                $segments
            );
        }

        return $originalData;
    }

    /**
     * Recursively extract a field path.
     *
     * Supports wildcard paths such as:
     *
     * images.*.title
     * cards.*.description
     * plans.*.features.*.feature
     */
    protected function extractPath(
        mixed $source,
        array &$target,
        array $segments,
        array $currentPath = []
    ): void {
        if (empty($segments)) {
            if ($source === null || $source === '') {
                return;
            }

            data_set(
                $target,
                implode('.', $currentPath),
                $source
            );

            return;
        }

        $segment = array_shift($segments);

        /*
        |--------------------------------------------------------------------------
        | Wildcard
        |--------------------------------------------------------------------------
        */

        if ($segment === '*') {
            if (! is_array($source)) {
                return;
            }

            foreach ($source as $key => $value) {
                $this->extractPath(
                    $value,
                    $target,
                    $segments,
                    [
                        ...$currentPath,
                        $key,
                    ]
                );
            }

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Normal Array Key
        |--------------------------------------------------------------------------
        */

        if (! is_array($source)) {
            return;
        }

        if (! array_key_exists($segment, $source)) {
            return;
        }

        $this->extractPath(
            $source[$segment],
            $target,
            $segments,
            [
                ...$currentPath,
                $segment,
            ]
        );
    }

    /**
     * Recursively apply a translation path.
     *
     * Wildcards are resolved against the existing
     * original data and the matching translated data.
     */
    protected function applyPath(
        mixed &$target,
        mixed $translationSource,
        array $segments
    ): void {
        if (empty($segments)) {
            if (
                is_string($translationSource)
                && $translationSource !== ''
            ) {
                $target = $translationSource;
            }

            return;
        }

        if (! is_array($target)) {
            return;
        }

        if (! is_array($translationSource)) {
            return;
        }

        $segment = array_shift($segments);

        /*
        |--------------------------------------------------------------------------
        | Wildcard
        |--------------------------------------------------------------------------
        */

        if ($segment === '*') {
            foreach ($target as $key => &$targetValue) {

                if (
                    ! array_key_exists(
                        $key,
                        $translationSource
                    )
                ) {
                    continue;
                }

                $this->applyPath(
                    $targetValue,
                    $translationSource[$key],
                    $segments
                );
            }

            unset($targetValue);

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Normal Array Key
        |--------------------------------------------------------------------------
        */

        if (
            ! array_key_exists(
                $segment,
                $target
            )
        ) {
            return;
        }

        if (
            ! array_key_exists(
                $segment,
                $translationSource
            )
        ) {
            return;
        }

        $this->applyPath(
            $target[$segment],
            $translationSource[$segment],
            $segments
        );
    }
}
