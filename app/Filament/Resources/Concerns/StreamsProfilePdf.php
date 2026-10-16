<?php

namespace App\Filament\Resources\Concerns;

use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\StreamedResponse;

trait StreamsProfilePdf
{
    /**
     * @param  array<string, mixed>  $viewData
     */
    protected function streamProfilePdf(string $view, array $viewData, string $filename): StreamedResponse
    {
        $pdf = Pdf::loadView($view, [...$viewData, 'hideProfileToolbar' => true])
            ->setPaper('a4')
            ->output();

        return response()->streamDownload(
            static function () use ($pdf): void {
                echo $pdf;
            },
            $filename,
            ['Content-Type' => 'application/pdf'],
        );
    }
}
