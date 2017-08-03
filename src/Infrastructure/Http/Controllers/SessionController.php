<?php

declare(strict_types=1);

namespace Francken\Infrastructure\Http\Controllers;

use Auth;

final class SessionController
{
    public function getLogin()
    {
        return view('login');
    }

    public function login()
    {
        $loggedIn = Auth::attempt([
            'email' => request()->input('email'),
            'password' => request()->input('passprhase'),
        ]);

        if ($loggedIn) {
            return redirect()->intended('/my-francken');
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
