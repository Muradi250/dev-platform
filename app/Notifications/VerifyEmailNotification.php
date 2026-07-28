<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailNotificationBase;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;

class VerifyEmailNotification extends VerifyEmailNotificationBase
{

    /**
     * Build the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {

        /*
        |--------------------------------------------------------------------------
        | Get Locale
        |--------------------------------------------------------------------------
        */

        $locale = request()->route('locale')
            ?? app()->getLocale();



        /*
        |--------------------------------------------------------------------------
        | Generate Verification URL
        |--------------------------------------------------------------------------
        */

        $verificationUrl = URL::temporarySignedRoute(

            'verification.verify',

            now()->addMinutes(60),

            [

                'locale' => $locale,

                'id' => $notifiable->getKey(),

                'hash' => sha1(
                    $notifiable->getEmailForVerification()
                ),

            ]

        );



        /*
        |--------------------------------------------------------------------------
        | Set Mail Language
        |--------------------------------------------------------------------------
        */

        App::setLocale($locale);



        return (new MailMessage)

            ->subject(
                __('auth.email_verify_subject')
            )

            ->line(
                __('auth.email_verify_line')
            )

            ->action(
                __('auth.email_verify_button'),
                $verificationUrl
            )

            ->line(
                __('auth.email_verify_footer')
            );

    }

}