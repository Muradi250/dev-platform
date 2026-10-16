<?php

namespace App\Services;

use App\Models\PageBlock;
use App\Contracts\TranslationProvider;
use Illuminate\Support\Collection;

class PageTranslationService
{
    public function __construct(
        protected PageBlockTranslationService $blockTranslationService,
        protected TranslationProvider $translationProvider
    ) {
    }

    /**
     * Translate one block without modifying the source block.
     */
    public function translateBlock(
        PageBlock $block,
        string $sourceLocale,
        string $targetLocale
    ): array {
        $originalData = is_array($block->data)
            ? $block->data
            : [];

        if (! $this->blockTranslationService->supports($block)) {
            return $originalData;
        }

        $translatableData = $this->blockTranslationService
            ->extractTranslatableData($block);

        if (empty($translatableData)) {
            return $originalData;
        }

        $translatedData = $this->translationProvider->translate(
            $translatableData,
            $sourceLocale,
            $targetLocale,
            'Page block type: ' . $block->type
        );

        return $this->blockTranslationService->applyTranslations(
            $block,
            $translatedData
        );
    }

    /**
     * Translate all blocks without saving anything.
     */
    public function translateBlocks(
        Collection $blocks,
        string $sourceLocale,
        string $targetLocale
    ): array {
        $translatedBlocks = [];

        foreach ($blocks as $block) {
            $translatedBlocks[] = [
                'source_block_id' => $block->id,
                'type' => $block->type,
                'data' => $this->translateBlock(
                    $block,
                    $sourceLocale,
                    $targetLocale
                ),
                'settings' => is_array($block->settings)
                    ? $block->settings
                    : [],
                'sort_order' => $block->sort_order,
                'is_active' => $block->is_active,
            ];
        }

        return $translatedBlocks;
    }
}
