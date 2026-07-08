<?php

use App\Http\Controllers\BrainController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AccountStatusController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
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
| Dashboard (User Panel)
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware([
    'auth',
    'verified',
    'status',
])->name('dashboard');


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


require __DIR__.'/auth.php';


/*
|--------------------------------------------------------------------------
| Filament Admin Panel
|--------------------------------------------------------------------------
|
| Route های /admin توسط Filament مدیریت می‌شوند.
|
*/


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