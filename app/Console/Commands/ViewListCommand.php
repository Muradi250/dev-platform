<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ViewListCommand extends Command
{
    protected $signature = 'view:list';
    protected $description = 'List all Blade views in the project';

    public function handle()
    {
        $files = File::allFiles(resource_path('views'));

        foreach ($files as $file) {
            $path = str_replace(resource_path('views') . DIRECTORY_SEPARATOR, '', $file->getRealPath());
            $path = str_replace('.blade.php', '', $path);
            $this->info($path);
        }

        return 0;
    }
}