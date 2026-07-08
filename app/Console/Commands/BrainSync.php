<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class BrainSync extends Command
{
    protected $signature = 'brain:sync';
    protected $description = 'Advanced Brain Auto Analyzer (Roadmap-based)';

    public function handle()
    {
        $path = storage_path('app/brain.json');

        if (!File::exists($path)) {
            $this->error("Brain file not found!");
            return;
        }

        $brain = json_decode(File::get($path), true);

        // =========================================
        // 1. ROADMAP-BASED PROGRESS (MAIN FIX)
        // =========================================

        $totalPhases = 0;
        $completed = 0;

        foreach ($brain['roadmap'] as $key => $phase) {

            $totalPhases++;

            if (($phase['status'] ?? null) === 'done') {
                $completed += 1;
            }

            if (($phase['status'] ?? null) === 'in_progress') {
                $completed += 0.5;
            }
        }

        $progress = $totalPhases > 0
            ? intval(($completed / $totalPhases) * 100)
            : 0;

        // =========================================
        // 2. AUTO ANALYSIS (OPTIONAL TECH CHECK)
        // =========================================

        $views = [
            'brain/dashboard.blade.php',
            'auth/login.blade.php',
            'auth/register.blade.php'
        ];

        $viewScore = 0;

        foreach ($views as $view) {
            if (File::exists(resource_path('views/' . $view))) {
                $viewScore++;
            }
        }

        $controllers = [
            'BrainController.php'
        ];

        $controllerScore = 0;

        foreach ($controllers as $controller) {
            if (File::exists(app_path('Http/Controllers/' . $controller))) {
                $controllerScore++;
            }
        }

        // =========================================
        // 3. UPDATE BRAIN
        // =========================================

        $brain['auto_analysis'] = [
            'views_score' => $viewScore,
            'controllers_score' => $controllerScore,
            'progress' => $progress,
            'last_sync' => now()->toDateTimeString()
        ];

        // =========================================
        // 4. UPDATE SPECIFIC PHASE (CORE ENGINE)
        // =========================================

        if (isset($brain['roadmap']['1_core_engine'])) {

            $brain['roadmap']['1_core_engine']['progress'] = $progress;

            if ($progress >= 100) {
                $brain['roadmap']['1_core_engine']['status'] = 'done';
            } elseif ($progress > 0) {
                $brain['roadmap']['1_core_engine']['status'] = 'in_progress';
            }
        }

        // =========================================
        // 5. SAVE
        // =========================================

        File::put(
            $path,
            json_encode($brain, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        $this->info("🧠 Brain Sync Completed!");
        $this->info("📊 Roadmap Progress: {$progress}%");
        $this->info("🕒 Last Update: " . now());
    }
}