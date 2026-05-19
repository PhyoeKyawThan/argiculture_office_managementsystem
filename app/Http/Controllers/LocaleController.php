<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function switch(Request $request, string $locale): RedirectResponse
    {
        $supported = config('app.supported_locales', ['en', 'my']);

        abort_unless(in_array($locale, $supported, true), 400);

        $request->session()->put('locale', $locale);

        return redirect()->back();
    }
}
