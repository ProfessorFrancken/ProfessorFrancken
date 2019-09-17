<?php

declare(strict_types=1);

namespace Francken\Domain\Committees;

use Broadway\EventSourcing\EventSourcingRepository;

final class CommitteeRepository
{
    /**
     * @var EventSourcingRepository
     */
    private $repo;

    /**
     * CommitteeRepository constructor.
     * @param $repo
     */
    public function __construct(EventSourcingRepository $repo)
    {
        $this->repo = $repo;
    }

    
    public function load(CommitteeId $committeeId) : Committee
    {
        return $this->repo->load((string)$committeeId);
    }

    
    public function save(Committee $committee) : void
    {
        $this->repo->save($committee);
    }
}
