<?php

declare(strict_types=1);

namespace Francken\Application\Members\Registration;

use Francken\Application\ReadModelRepository;
use Francken\Domain\Members\Registration\RegistrationRequestId;

final class RequestStatusRepository
{
    private $repo;

    public function __construct(ReadModelRepository $repo)
    {
        $this->repo = $repo;
    }

    public function save(RequestStatus $requestStatus) : void
    {
        $this->repo->save($requestStatus);
    }

    public function find(RegistrationRequestId $id) : RequestStatus
    {
        return $this->repo->find((string)$id);
    }

    public function findAll() : array
    {
        return $this->repo->findAll();
    }

    public function remove(RegistrationRequestId $id) : void
    {
        $this->repo->remove((string)$id);
    }
}
