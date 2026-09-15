<?php

require __DIR__ . '/bootstrap/app.php';

$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\Page;
use App\Models\PageBlock;

// Fix Page
$page = Page::find(17);

if ($page) {
    $page->status = 'published';
    $page->save();
    echo "✅ Page 17 updated to published\n";
} else {
    echo "❌ Page 17 not found\n";
}

// Check blocks
$blocks = PageBlock::where('page_id', 17)->get();
echo "✅ Blocks count: " . $blocks->count() . "\n";

foreach ($blocks as $block) {
    echo "  - Block ID: {$block->id}, Type: {$block->type}, Active: " . ($block->is_active ? 'Yes' : 'No') . "\n";
}

echo "\n✅ Fix complete!\n";
