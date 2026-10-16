<?php

namespace App\Contracts;

interface TranslationProvider
{
    /**
     * Translate a structured array of human-readable content.
     *
     * @param array $data
     * @param string $sourceLocale
     * @param string $targetLocale
     * @param string $context
     * @return array
     */
    public function translate(
        array $data,
        string $sourceLocale,
        string $targetLocale,
        string $context = ''
    ): array;
}
