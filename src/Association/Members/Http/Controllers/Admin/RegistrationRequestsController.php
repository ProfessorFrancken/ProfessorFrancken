<?php

declare(strict_types=1);

namespace Francken\Association\Members\Http\Controllers\Admin;

use Francken\Association\Members\Http\Requests\RegistrationRequest;
use Francken\Association\Members\Registration\Registration;
use Francken\Infrastructure\Http\Controllers\Controller;
use Francken\Shared\Clock\Clock;

final class RegistrationRequestsController extends Controller
{
    public function index()
    {
        $requests = Registration::paginate();

        return view('admin.registration-requests.index', [
            'requests' => $requests,
            'breadcrumbs' => [
                ['url' => action([self::class, 'index']), 'text' => 'Registration requests'],
            ]
        ]);
    }

    public function show(Registration $registration)
    {
        return view('admin.registration-requests.show', [
            'registration' => $registration,
            'breadcrumbs' => [
                ['url' => action([self::class, 'index']), 'text' => 'Registration requests'],
                ['url' => action([self::class, 'show'], ['registration' => $registration->id]), 'text' => $registration->fullname->toString()],
            ]
        ]);
    }

    public function edit(Registration $registration)
    {
        return view('admin.registration-requests.edit', [
            'registration' => $registration,
            'amountOfStudies' => count($registration->studies) - 1,
            'breadcrumbs' => [
                ['url' => action([self::class, 'index']), 'text' => 'Registration requests'],
                ['url' => action([self::class, 'show'], ['registration' => $registration->id]), 'text' => $registration->fullname->toString()],
                ['url' => action([self::class, 'edit'], ['registration' => $registration->id]), 'text' => 'Edit'],
            ]
        ]);
    }

    public function remove(Registration $registration)
    {
        $registration->delete();

        return redirect()->action([self::class, 'index'])
            ->with([
                'status' => 'Successfully archived request from ' . $registration->fullname()->toString()
            ]);
    }

    public function approve(Registration $registration, Clock $clock)
    {
        // TODO
        $boardMember = null;
        $registration->approve($boardMember, $clock->now());

        return redirect()->action([self::class, 'index'])
            ->with([
                'status' => 'Successfully approved request from ' . $registration->fullname()->toString()
            ]);
    }
}
