<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class BrainController extends Controller
{
    public function index()
    {
        $path = storage_path('app/brain.json');

        Artisan::call('brain:sync');

        if (! File::exists($path)) {
            $defaultBrain = [
                'project' => 'Dev Platform',
                'roadmap' => [
                    [
                        'title' => 'Project Setup',
                        'status' => 'in_progress',
                        'result' => 'Live dashboard ready',
                    ],
                ],
                'auto_analysis' => [
                    'views_score' => 0,
                    'controllers_score' => 0,
                    'progress' => 0,
                    'last_sync' => now()->toDateTimeString(),
                ],
            ];

            File::put($path, json_encode($defaultBrain, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }

        $brain = json_decode(File::get($path), true);

        if (! is_array($brain)) {
            abort(500, 'Invalid brain data.');
        }

        $brain['auto_analysis']['last_sync'] = $brain['auto_analysis']['last_sync'] ?? now()->toDateTimeString();

        return view('brain.dashboard', compact('brain'));
    }
}