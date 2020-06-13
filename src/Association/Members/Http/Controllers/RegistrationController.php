<?php

declare(strict_types=1);

namespace Francken\Association\Members\Http\Controllers;

use Francken\Association\Members\Http\Requests\RegistrationRequest;
use Francken\Association\Members\Registration\Registration;

final class RegistrationController
{
    public function index()
    {
        return view('registration.request')
            ->with([
                'amountOfStudies' => session()->get('amountOfStudies', 1) - 1,
                // 'errors' => session()->get('errors'),
            ]);
    }

    public function store(RegistrationRequest $request, \Illuminate\Routing\UrlGenerator $urlGenerator)
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

        $urlGenerator->temporarySignedRoute(
        );

        // TODO: Add signed url
        return redirect()->action(
            [self::class, 'show'],
            ['id' => $registration->id]
        );
    }

    public function show(Registration $registration)
    {
        return view('registration.success')->with([
            'registration' => $registration
        ]);
    }
}
