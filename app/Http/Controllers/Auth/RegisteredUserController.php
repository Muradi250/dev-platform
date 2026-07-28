<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class RegisteredUserController extends Controller
{

    /**
     * Display registration page
     */
    public function create(): View
    {
        return view('auth.register');
    }



    /**
     * Handle registration request
     */
    public function store(Request $request): RedirectResponse
    {

        /*
        |--------------------------------------------------------------------------
        | Current Locale
        |--------------------------------------------------------------------------
        */

        $locale = request()->route('locale') ?? app()->getLocale();



        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'name' => [
                'required',
                'string',
                'max:255'
            ],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:' . User::class
            ],

            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults()
            ],

        ]);



        $validated['email'] = Str::lower(
            $validated['email']
        );



        /*
        |--------------------------------------------------------------------------
        | Create User
        |--------------------------------------------------------------------------
        */

        $user = User::create([

            'name' => $validated['name'],

            'email' => $validated['email'],

            'password' => Hash::make(
                $validated['password']
            ),

            'status' => 'pending',

        ]);





        /*
        |--------------------------------------------------------------------------
        | Default Role
        |--------------------------------------------------------------------------
        */

        Role::firstOrCreate([

            'name' => 'user',

            'guard_name' => 'web',

        ]);



        $user->assignRole('user');





        /*
        |--------------------------------------------------------------------------
        | Login User
        |--------------------------------------------------------------------------
        */

        Auth::login($user);





        /*
        |--------------------------------------------------------------------------
        | Email Verification Event
        |--------------------------------------------------------------------------
        */

        //event(new Registered($user));





        /*
        |--------------------------------------------------------------------------
        | Redirect To Dashboard
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('dashboard', [

                'locale' => $locale,

            ]);

    }

}