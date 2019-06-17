<?php

declare(strict_types=1);

namespace Francken\Association\Photos\Http\Controllers;

use Francken\Association\Photos\PhotosAuthentication;
use Illuminate\Http\Request;

final class AuthenticationController
{
    /**
     * @var PhotosAuthentication
     */
    private $auth;

    public function __construct(PhotosAuthentication $auth)
    {
        $this->auth = $auth;
    }

    public function index()
    {
        return view('association.photos.login');
    }

    public function store(Request $request)
    {
        $password = $request->get('password', '');

        $success = $this->auth->login($password);

        return redirect()
            ->action([PhotosController::class, 'index'])
            ->with('private-album-login', $success);
    }
}
