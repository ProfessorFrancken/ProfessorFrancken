<?php

declare(strict_types=1);

namespace Francken\Application\Committees;

use Francken\Application\ReadModelRepository;
use Francken\Domain\Committees\CommitteeId;

final class CommitteesListRepository
{
    private $repo;

    public function __construct(ReadModelRepository $repo)
    {
        $this->repo = $repo;
    }

    public function save(CommitteesList $committee) : void
    {
        $this->repo->save($committee);
    }

    public function find(CommitteeId $id) : CommitteesList
    {
        return $this->repo->find((string)$id);
    }

    public function findAll() : array
    {
        return $this->repo->findAll();
    }
}
