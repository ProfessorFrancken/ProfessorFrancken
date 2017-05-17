<?php

declare(strict_types=1);

namespace Francken\Domain\Activities;

use Broadway\EventSourcing\EventSourcingRepository;

final class ActivityRepository
{
    /**
     * @var EventSourcingRepository
     */
    private $repo;

    /**
     * ActivityRepository constructor.
     * @param $repo
     */
    public function __construct(EventSourcingRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @param ActivityId $ActivityId
     * @return Activity
     */
    public function load(ActivityId $activityId) : Activity
    {
        return $this->repo->load((string)$activityId);
    }

    /**
     * @param Activity $Activity
     */
    public function save(Activity $activity)
    {
        $this->repo->save($activity);
    }
}
