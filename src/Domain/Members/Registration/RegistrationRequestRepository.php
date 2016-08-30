<?php

declare(strict_types=1);

namespace Francken\Domain\Members\Registration;

use Broadway\EventSourcing\EventSourcingRepository;

final class RegistrationRequestRepository
{
    /**
     * @var EventSourcingRepository
     */
    private $repo;

    /**
     * RegistrationRequestRepository constructor.
     * @param $repo
     */
    public function __construct(EventSourcingRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @param RegistrationRequestId $registrationRequestId
     * @return RegistrationRequest
     */
    public function load(RegistrationRequestId $registrationRequestId) : RegistrationRequest
    {
        return $this->repo->load((string)$registrationRequestId);
    }

    /**
     * @param RegistrationRequest $registrationRequest
     */
    public function save(RegistrationRequest $registrationRequest)
    {
        $this->repo->save($registrationRequest);
    }
}
