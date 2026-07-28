<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;


class VerifyEmailController extends Controller
{

    /**
     * Mark user's email as verified.
     */
    public function __invoke(
        EmailVerificationRequest $request
    ): RedirectResponse {


        /*
        |--------------------------------------------------------------------------
        | Current Locale
        |--------------------------------------------------------------------------
        */

        $locale = $request->route('locale')
            ?? app()->getLocale();



        /*
        |--------------------------------------------------------------------------
        | Check Verification Status
        |--------------------------------------------------------------------------
        */

        if (! $request->user()->hasVerifiedEmail()) {


            if ($request->user()->markEmailAsVerified()) {


                event(
                    new Verified($request->user())
                );


            }

        }



        /*
        |--------------------------------------------------------------------------
        | Redirect To Localized Dashboard
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('login', [

                'locale' => $locale,

            ])
            ->with(
                'verified',
                true
            );


    }

}