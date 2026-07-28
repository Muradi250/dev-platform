<?php

use App\Http\Controllers\BrainController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AccountStatusController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Public Website Routes (Multi Language)
|--------------------------------------------------------------------------
|
| Supported Locales:
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

        Route::get('/', function () {

            return view('public.home');

        })->name('public.home');



        /*
        |--------------------------------------------------------------------------
        | Dashboard (Localized)
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

    });



/*
|--------------------------------------------------------------------------
| Account Status Page
|--------------------------------------------------------------------------
*/

Route::get('/account-status', [AccountStatusController::class, 'index'])
    ->name('account.status');



/*
|--------------------------------------------------------------------------
| Default Dashboard Redirect
|--------------------------------------------------------------------------
|
| جلوگیری از خراب شدن لینک های قبلی /dashboard
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
])->group(function () {


    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');


    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');


    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');


});



/*
|--------------------------------------------------------------------------
| Laravel Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';



/*
|--------------------------------------------------------------------------
| Brain Panel (Custom)
|--------------------------------------------------------------------------
*/

Route::get('/brain', [BrainController::class, 'index'])
    ->middleware([
        'auth',
        'status',
    ])
    ->name('brain.dashboard');