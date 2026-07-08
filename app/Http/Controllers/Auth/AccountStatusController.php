<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AccountStatusController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('auth.account-status', [
            'user' => $user,
            'status' => $user->status,
            'supportEmail' => 'amuradi250@gmail.com',
        ]);
    }
}