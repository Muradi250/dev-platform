<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\User;
use Illuminate\Http\Request;

class PublicPageController extends Controller
{
    /**
     * Display the public homepage.
     */
    public function home(Request $request)
    {
        $locale = $request->route('locale') ?? app()->getLocale();

        $page = Page::query()
            ->where('slug', 'home')
            ->where('locale', $locale)
            ->where('status', 'published')
            ->with([
                'blocks' => function ($query) {
                    $query
                        ->where('is_active', true)
                        ->orderBy('sort_order');
                },
            ])
            ->first();

        if (! $page) {
            abort(404);
        }

        return $this->renderPage($page);
    }

    /**
     * Display a dynamic public page.
     *
     * Examples:
     * /en/dev-platform
     * /fa/dev-platform
     * /ps/dev-platform
     */
    public function show(
        Request $request,
        string $locale,
        string $slug
    ) {
        $page = Page::query()
            ->where('slug', $slug)
            ->where('locale', $locale)
            ->where('status', 'published')
            ->with([
                'blocks' => function ($query) {
                    $query
                        ->where('is_active', true)
                        ->orderBy('sort_order');
                },
            ])
            ->first();

        if (! $page) {
            abort(404);
        }

        return $this->renderPage($page);
    }

    /**
     * Render every public page through the Page Builder.
     */
    protected function renderPage(Page $page)
    {
        $stats = [
            'users' => User::count(),
            'organizations' => 0,
            'modules' => 18,
            'status' => 'Active',
        ];

        /*
        |--------------------------------------------------------------------------
        | PAGE SETTINGS
        |--------------------------------------------------------------------------
        */

        $settings = is_array($page->settings)
            ? $page->settings
            : [];


        /*
        |--------------------------------------------------------------------------
        | PAGE BLOCKS
        |--------------------------------------------------------------------------
        */

        $blocks = $page->blocks;


        /*
        |--------------------------------------------------------------------------
        | PUBLIC PAGE
        |--------------------------------------------------------------------------
        */

        return view('public.page', [
            'page' => $page,
            'blocks' => $blocks,
            'settings' => $settings,
            'stats' => $stats,
        ]);
    }
}