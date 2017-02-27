<?php

declare(strict_types=1);

namespace Francken\Application\Activities;

use Francken\Application\ReadModelRepository;
use Francken\Domain\Activities\ActivityId;

final class ActivityRepository
{
    private $repo;

    public function __construct(ReadModelRepository $repo)
    {
        $this->repo = $repo;
    }

    public function save(Activity $activity)
    {
        $this->repo->save($activity);
    }

    public function find(ActivityId $id) : Activity
    {
        return $this->repo->find((string)$id);
    }

    public function findAll() : array
    {
        return $this->repo->findAll();
    }

    public function remove(ActivityId $id)
    {
        $this->repo->remove((string)$id);
    }
}
