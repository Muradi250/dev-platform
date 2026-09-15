<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Page;
use App\Models\PageBlock;

class FixDevPlatformPage extends Command
{
    protected $signature = 'fix:dev-platform-page';
    protected $description = 'Fix Dev-platform page status and blocks';

    public function handle()
    {
        $page = Page::find(17);

        if (!$page) {
            $this->error('❌ Page 17 not found');
            return 1;
        }

        // Update status
        $page->status = 'published';
        $page->save();

        $this->info('✅ Page 17 status updated to published');

        // Check blocks
        $blocks = PageBlock::where('page_id', 17)->get();
        $this->info("✅ Blocks count: {$blocks->count()}");

        foreach ($blocks as $block) {
            $status = $block->is_active ? 'Active' : 'Inactive';
            $this->line("  - Block ID: {$block->id}, Type: {$block->type}, Status: {$status}");
        }

        $this->info('✅ Fix complete!');
        return 0;
    }
}
