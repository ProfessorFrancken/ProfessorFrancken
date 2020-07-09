<?php

declare(strict_types=1);

namespace Francken\Association\Photos\Http\Controllers;

use Francken\Association\Photos\PhotosAuthentication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class AuthenticationController
{
    private PhotosAuthentication $auth;

    public function __construct(PhotosAuthentication $auth)
    {
        $this->auth = $auth;
    }

    public function index() : View
    {
        return view('association.photos.login');
    }

    public function store(Request $request) : RedirectResponse
    {
        $password = $request->get('password', '');

        $success = $this->auth->login($password);

        return redirect()
            ->action([PhotosController::class, 'index'])
            ->with('private-album-login', $success);
    }
}
