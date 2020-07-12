<?php

declare(strict_types=1);

namespace Francken\Association\Members\Http;

use Francken\Association\Members\Http\Requests\ContactDetailsRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class ContactDetailsController
{
    public function index(Request $request) : View
    {
        $member = $request->user()->member;

        return view('profile.contact-details.index')
            ->with([
                'member' => $member,
                'breadcrumbs' => [
                    ['url' => '/profile', 'text' => 'Profile'],
                    ['url' => action([self::class, 'index']), 'text' => 'Contact details'],
                ]
            ]);
    }

    public function update(ContactDetailsRequest $request) : RedirectResponse
    {
        $member = $request->user()->member;
        $member->changeEmail($request->email(), $request->mailinglistMail());
        $member->changeAddress($request->address(), $request->mailinglistFranckenVrij());
        $member->changePhoneNumber($request->phoneNumber());

        return redirect()->action([ProfileController::class, 'index']);
    }
}
