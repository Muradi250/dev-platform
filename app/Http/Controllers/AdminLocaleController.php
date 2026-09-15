<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminLocaleController extends Controller
{
    public function switch(Request $request)
    {
        $locale = $request->locale;

        abort_unless(
            in_array($locale, ['en', 'fa', 'ps']),
            404
        );

        session([
            'admin_locale' => $locale,
        ]);

        return redirect()->back();
    }
}
