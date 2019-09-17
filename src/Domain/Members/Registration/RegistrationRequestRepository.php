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

    
    public function load(RegistrationRequestId $registrationRequestId) : RegistrationRequest
    {
        return $this->repo->load((string)$registrationRequestId);
    }

    
    public function save(RegistrationRequest $registrationRequest) : void
    {
        $this->repo->save($registrationRequest);
    }
}
