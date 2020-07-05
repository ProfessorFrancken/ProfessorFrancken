<?php

declare(strict_types=1);

namespace Francken\Association\Members\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Francken\Association\Members\Http\Requests\RegistrationRequest;
use Francken\Association\Members\Registration\Registration;
use Francken\Shared\Clock\Clock;
use Illuminate\Routing\UrlGenerator;

final class RegistrationController
{
    public function index(): View
    {
        return view('registration.index')
            ->with([
                'amountOfStudies' => session()->get('amountOfStudies', 1) - 1,
                // 'errors' => session()->get('errors'),
            ]);
    }

    public function store(RegistrationRequest $request, UrlGenerator $urlGenerator, Clock $clock): RedirectResponse
    {
        $registration = Registration::submit(
            // PersonalDetails
            $request->personalDetails(),

            // Contact details
            $request->contactDetails(),

            // Study details
            $request->studyDetails(),

            //  Payment details
            $request->paymentDetails(),
            $request->wantsToJoinACommittee(),
            $request->notes()
        );

        $url = $urlGenerator->temporarySignedRoute(
            'registration.show',
            $clock->now()->modify('+1 week'),
            ['registration' => $registration->id]
        );

        return redirect()->to($url);
    }

    public function show(Registration $registration): View
    {
        return view('registration.show')->with([
            'registration' => $registration
        ]);
    }

    public function verify(Registration $registration, UrlGenerator $urlGenerator, Clock $clock): RedirectResponse
    {
        $registration->confirmEmail($clock->now());

        $url = $urlGenerator->signedRoute(
            'registration.show',
            ['registration' => $registration->id]
        );

        return redirect()->to($url);
    }
}
