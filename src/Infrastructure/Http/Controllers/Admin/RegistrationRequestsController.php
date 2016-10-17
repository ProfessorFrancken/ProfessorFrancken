<?php

declare(strict_types=1);

namespace Francken\Infrastructure\Http\Controllers\Admin;

use DateTimeImmutable;
use Francken\Application\Members\Registration\RequestStatus;
use Francken\Application\ReadModelRepository as Repository;
use Francken\Domain\Members\Registration\RegistrationRequestId;
use Francken\Infrastructure\Http\Controllers\Controller;

final class RegistrationRequestsController extends Controller
{
    private $requests;

    public function __construct(Repository $requests)
    {
        $this->requests = $requests;
    }


    public function index()
    {
        return view('admin.registration-requests.index', [
            'requests' => $this->requests->findAll()
        ]);
    }

    public function show($requestId)
    {
        return view('admin.registration-requests.show', [
            'request' => $this->requests->find($requestId)
        ]);
    }
}
