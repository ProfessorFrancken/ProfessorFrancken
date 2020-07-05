<?php

declare(strict_types=1);

namespace Francken\Shared\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Auth;

final class SessionController
{
    public function getLogin()
    {
        return view('login');
    }

    public function login(Request $request): RedirectResponse
    {
        $rememberUser = true;

        $loggedIn = Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('passphrase'),
        ], $rememberUser);

        if ($loggedIn) {
            return redirect()->intended('profile');
        }

        return redirect('login')->withInput();
    }

    public function logout()
    {
        try {
            Auth::logOut();
        } finally {
            return redirect('/');
        }
    }
}
