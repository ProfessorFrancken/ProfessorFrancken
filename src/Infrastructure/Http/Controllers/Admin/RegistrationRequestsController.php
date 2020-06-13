<?php

declare(strict_types=1);

namespace Francken\Infrastructure\Http\Controllers\Admin;

use Francken\Association\Members\Registration\Registration;
use Francken\Infrastructure\Http\Controllers\Controller;

final class RegistrationRequestsController extends Controller
{
    public function index()
    {
        $requests = Registration::paginate();

        return view('admin.registration-requests.index', [
            'requests' => $requests
        ]);
    }

    public function show(Registration $request)
    {
        return view('admin.registration-requests.show', [
            'request' => $request
        ]);
    }

    public function remove(Registration $request)
    {
        $request->delete();

        return redirect()->action([self::class, 'index'])
            ->with([
                'status' => 'Successfully archived request from ' . $request->fullname()->toString()
            ]);
    }
}
