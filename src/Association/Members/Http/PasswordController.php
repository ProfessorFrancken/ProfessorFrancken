<?php

declare(strict_types=1);

namespace Francken\Association\Members\Http;

use Francken\Association\Members\Http\Requests\PasswordRequest;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class PasswordController
{
    public function index(Request $request) : View
    {
        $member = $request->user()->member;

        return view('profile.password.index')
            ->with([
                'member' => $member,
                'breadcrumbs' => [
                    ['url' => '/profile', 'text' => 'Profile'],
                ]
            ]);
    }

    public function update(PasswordRequest $request, Hasher $passwordHasher) : RedirectResponse
    {
        $user = $request->user();
        $user->password = $passwordHasher->make($request->password());
        $user->save();

        return redirect()->action([ProfileController::class, 'index']);
    }
}
