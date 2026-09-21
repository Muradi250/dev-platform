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
     * Find a translation of the current Page.
     *
     * This method is used by the public language switcher.
     */
    public function translation(Page $page, string $locale): ?Page
    {
        if ($page->locale === $locale) {
            return $page;
        }

        return $page->translation($locale);
    }


    /**
     * Render every public page through the Page Builder.
     */
    protected function renderPage(Page $page)
    {
        /*
        |--------------------------------------------------------------------------
        | UNPUBLISHED PAGE
        |--------------------------------------------------------------------------
        */

        if ($page->status === 'draft') {
            return view('public.status.unpublished', [
                'page' => $page,
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | ONLY PUBLISHED PAGES ARE RENDERED PUBLICLY
        |--------------------------------------------------------------------------
        */

        if ($page->status !== 'published') {
            abort(404);
        }


        /*
        |--------------------------------------------------------------------------
        | PUBLIC STATISTICS
        |--------------------------------------------------------------------------
        */

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
