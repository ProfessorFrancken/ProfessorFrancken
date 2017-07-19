<?php

declare(strict_types=1);

namespace Francken\Infrastructure\Http\Controllers;

final class SessionController
{
    public function login()
    {
        Auth::loginUsingId(1);

        return redirect('/');
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
