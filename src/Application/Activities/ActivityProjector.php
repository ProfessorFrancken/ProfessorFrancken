<?php

declare(strict_types=1);

namespace Francken\Application\Activities;

use Francken\Application\Projector;

use Francken\Domain\Activities\ActivityId;

// events:
use Francken\Domain\Activities\Events\ActivityPlanned;

final class ActivityProjector extends Projector
{
    private $activities;

    public function __construct(
        ActivityRepository $activities
    ) {
        $this->activities = $activities;
    }

    public function whenActivityPlanned(ActivityPlanned $event)
    {
        $activity = new Activity(
            $event->activityId(),
            $event->name(),
            false,
            // $event->description(),
            $event->category(),
            $event->schedule(),
            $event->location(),
            []
        );

        $this->activities->save($activity);
    }
}
