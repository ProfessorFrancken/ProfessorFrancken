<?php

declare(strict_types=1);

namespace Francken\Auth\Http\Controllers;

use Francken\Shared\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     */
    protected string $redirectTo = '/profile';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Login forms can send the page that the user should return to after
     * logging in. Only paths on this website are allowed, to prevent
     * redirecting users to other websites.
     *
     * @param mixed $user
     */
    protected function authenticated(Request $request, $user) : ?RedirectResponse
    {
        $redirectTo = $request->input('redirect_to');

        if ( ! is_string($redirectTo) || ! $this->isPathOnThisWebsite($redirectTo)) {
            return null;
        }

        return redirect($redirectTo);
    }

    private function isPathOnThisWebsite(string $path) : bool
    {
        return str_starts_with($path, '/')
            && ! str_starts_with($path, '//')
            && ! str_contains($path, '\\');
    }
}
