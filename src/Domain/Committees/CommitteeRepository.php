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

    /**
     * @param CommitteeId $committeeId
     * @return Committee
     */
    public function load(CommitteeId $committeeId) : Committee
    {
return $this->repo->load((string)$committeeId);
    }

    /**
     * @param Committee $committee
     */
    public function save(Committee $committee)
    {
        $this->repo->save($committee);
    }
}
