<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Page;
use Illuminate\Http\Request;

class TestPageRoute extends Command
{
    protected $signature = 'test:page-route';
    protected $description = 'Test if Dev-platform page is accessible';

    public function handle()
    {
        $locale = 'en';
        $slug = 'dev-platform';

        $page = Page::query()
            ->where('slug', $slug)
            ->where('locale', $locale)
            ->where('status', 'published')
            ->first();

        if ($page) {
            $this->info("✅ Page FOUND: {$page->title}");
            $this->info("   Slug: {$page->slug}");
            $this->info("   Locale: {$page->locale}");
            $this->info("   Status: {$page->status}");
            
            $blocks = $page->blocks()->where('is_active', true)->orderBy('sort_order')->get();
            $this->info("   Blocks: {$blocks->count()}");
            foreach ($blocks as $block) {
                $this->line("     - {$block->type}");
            }
        } else {
            $this->error("❌ Page NOT FOUND");
            
            // Debug
            $all = Page::all();
            $this->line("All pages: " . $all->count());
            foreach ($all as $p) {
                $this->line("  - {$p->slug} ({$p->locale}) - {$p->status}");
            }
        }

        return 0;
    }
}
