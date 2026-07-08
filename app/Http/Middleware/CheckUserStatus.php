<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {

            $user = Auth::user();

            switch ($user->status) {

                case 'active':
                    // کاربر فعال است
                    break;


                case 'pending':

                    return redirect()
                        ->route('account.status');


                case 'suspended':

                    return redirect()
                        ->route('account.status');


                case 'banned':

                    return redirect()
                        ->route('account.status');


                default:

                    return redirect()
                        ->route('account.status');
            }
        }

        return $next($request);
    }
}