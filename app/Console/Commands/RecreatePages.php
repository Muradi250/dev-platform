<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Page;
use App\Models\PageBlock;

class RecreatePages extends Command
{
    protected $signature = 'recreate:pages';
    protected $description = 'Recreate Home and Dev-platform pages with blocks';

    public function handle()
    {
        // Create Home Page
        $home = Page::create([
            'title' => 'Home',
            'slug' => 'home',
            'locale' => 'en',
            'status' => 'published',
            'settings' => [
                'theme' => ['mode' => 'light'],
                'layout' => 'standard',
            ],
        ]);

        $this->info('✅ Home page created');

        // Add Hero block to Home
        PageBlock::create([
            'page_id' => $home->id,
            'type' => 'hero',
            'sort_order' => 1,
            'is_active' => true,
            'data' => [
                'title' => 'Welcome to Dev-Platform',
                'subtitle' => 'Build amazing things',
            ],
        ]);

        $this->info('✅ Hero block added to Home');

        // Create Dev-platform Page
        $devPlatform = Page::create([
            'title' => 'Dev-platform',
            'slug' => 'dev-platform',
            'locale' => 'en',
            'status' => 'published',
            'settings' => [
                'theme' => ['mode' => 'light'],
                'layout' => 'standard',
            ],
        ]);

        $this->info('✅ Dev-platform page created');

        // Add Hero block to Dev-platform
        PageBlock::create([
            'page_id' => $devPlatform->id,
            'type' => 'hero',
            'sort_order' => 1,
            'is_active' => true,
            'data' => [
                'title' => 'Dev-Platform',
                'subtitle' => 'The Ultimate Development Platform',
            ],
        ]);

        $this->info('✅ Hero block added to Dev-platform');

        // Add Features block to Dev-platform
        PageBlock::create([
            'page_id' => $devPlatform->id,
            'type' => 'features',
            'sort_order' => 2,
            'is_active' => true,
            'data' => [
                'title' => 'Key Features',
                'features' => [
                    ['title' => 'Easy to Use', 'icon' => 'star'],
                    ['title' => 'Powerful', 'icon' => 'rocket'],
                    ['title' => 'Scalable', 'icon' => 'trending-up'],
                ],
            ],
        ]);

        $this->info('✅ Features block added to Dev-platform');

        // Add CTA block to Dev-platform
        PageBlock::create([
            'page_id' => $devPlatform->id,
            'type' => 'cta',
            'sort_order' => 3,
            'is_active' => true,
            'data' => [
                'title' => 'Ready to get started?',
                'button_text' => 'Get Started Now',
            ],
        ]);

        $this->info('✅ CTA block added to Dev-platform');

        $this->info('✅ All pages and blocks created successfully!');
        return 0;
    }
}
