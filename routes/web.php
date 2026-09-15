
<?php

use App\Http\Controllers\AdminLocaleController;
use App\Http\Controllers\Auth\AccountStatusController;
use App\Http\Controllers\BrainController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicPageController;
use App\Http\Controllers\TestimonialController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
|
| IMPORTANT:
| auth.php MUST be loaded before the dynamic public page route.
|
| Otherwise:
|
| /en/login
| /en/register
| /en/forgot-password
|
| can be captured by:
|
| /{locale}/{slug}
|
*/

require __DIR__ . '/auth.php';


/*
|--------------------------------------------------------------------------
| Public Website Routes (Multi Language)
|--------------------------------------------------------------------------
|
| Supported Locales:
|
| en = English
| fa = Persian
| ps = Pashto
|
*/

Route::prefix('{locale}')
    ->middleware('setLocale')
    ->whereIn('locale', [
        'en',
        'fa',
        'ps',
    ])
    ->group(function () {


        /*
        |--------------------------------------------------------------------------
        | Public Home
        |--------------------------------------------------------------------------
        */

        Route::get('/', [
            PublicPageController::class,
            'home',
        ])
        ->name('public.home');


        /*
        |--------------------------------------------------------------------------
        | Testimonials
        |--------------------------------------------------------------------------
        */

        Route::get('/testimonials', [
            TestimonialController::class,
            'create',
        ])
        ->name('testimonials.create');


        Route::post('/testimonials', [
            TestimonialController::class,
            'store',
        ])
        ->name('testimonials.store');


        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', function () {

            return view('dashboard');

        })
        ->middleware([
            'auth',
            'verified',
            'status',
        ])
        ->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | Dynamic Public Pages
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        | This route MUST be the LAST route inside this locale group.
        |
        | Examples:
        |
        | /en/dev-platform
        | /fa/dev-platform
        | /ps/dev-platform
        |
        */

        Route::get('/{slug}', [
            PublicPageController::class,
            'show',
        ])
        ->where('slug', '[A-Za-z0-9\-]+')
        ->name('public.page');

    });


/*
|--------------------------------------------------------------------------
| Account Status Page
|--------------------------------------------------------------------------
*/

Route::get('/account-status', [
    AccountStatusController::class,
    'index',
])
->name('account.status');


/*
|--------------------------------------------------------------------------
| Default Dashboard Redirect
|--------------------------------------------------------------------------
|
| Prevent old /dashboard links from breaking.
|
*/

Route::get('/dashboard', function () {

    return redirect('/en/dashboard');

})
->middleware([
    'auth',
    'verified',
    'status',
]);


/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'status',
])
->group(function () {


    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [
        ProfileController::class,
        'edit',
    ])
    ->name('profile.edit');


    Route::patch('/profile', [
        ProfileController::class,
        'update',
    ])
    ->name('profile.update');


    Route::delete('/profile', [
        ProfileController::class,
        'destroy',
    ])
    ->name('profile.destroy');

});


/*
|--------------------------------------------------------------------------
| Brain Panel (Custom)
|--------------------------------------------------------------------------
*/

Route::get('/brain', [
    BrainController::class,
    'index',
])
->middleware([
    'auth',
    'status',
])
->name('brain.dashboard');


/*
|--------------------------------------------------------------------------
| Admin Panel Language Switcher
|--------------------------------------------------------------------------
*/

Route::get('/admin/language/{locale}', function (string $locale) {

    abort_unless(
        in_array($locale, [
            'en',
            'fa',
            'ps',
        ]),
        404
    );


    session([
        'admin_locale' => $locale,
    ]);


    return redirect()->back();

})
->name('admin.language');


/*
|--------------------------------------------------------------------------
| Admin Language Switch (POST)
|--------------------------------------------------------------------------
*/

Route::post('/admin/locale', [
    AdminLocaleController::class,
    'switch',
])
->name('admin.locale');

