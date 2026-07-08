<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class ViewAnalyzer extends Command
{
    protected $signature = 'view:analyze';
    protected $description = 'Analyze Blade views: used, unused, and statistics';

    public function handle()
    {
        $this->info("🔍 Starting View Analysis...\n");

        // 1. Get all views
        $viewFiles = File::allFiles(resource_path('views'));

        $allViews = [];

        foreach ($viewFiles as $file) {
            $path = str_replace(resource_path('views') . DIRECTORY_SEPARATOR, '', $file->getRealPath());
            $view = str_replace('.blade.php', '', $path);
            $view = str_replace('/', '.', $view);
            $view = str_replace('\\', '.', $view);

            $allViews[] = $view;
        }

        // 2. Scan usage in app folder
        $phpFiles = File::allFiles(app_path());

        $usedViews = [];

        foreach ($phpFiles as $file) {
            $content = File::get($file->getRealPath());

            foreach ($allViews as $view) {
                if (str_contains($content, "view('$view')") || str_contains($content, "view(\"$view\")")) {
                    $usedViews[$view][] = $file->getRealPath();
                }
            }
        }

        // 3. Results
        $this->info("📊 TOTAL VIEWS: " . count($allViews));
        $this->info("✅ USED VIEWS: " . count($usedViews));

        $unused = array_diff($allViews, array_keys($usedViews));

        $this->info("❌ UNUSED VIEWS: " . count($unused));

        $this->line("\n================ USED VIEWS ================\n");

        foreach ($usedViews as $view => $files) {
            $this->line("✔ $view");
        }

        $this->line("\n================ UNUSED VIEWS ================\n");

        foreach ($unused as $view) {
            $this->warn("✖ $view");
        }

        $this->info("\n🎯 Analysis Completed!");

        return 0;
    }
}