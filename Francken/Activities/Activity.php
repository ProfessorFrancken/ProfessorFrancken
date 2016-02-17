<?php

namespace Francken\Activities;

use Broadway\EventSourcing\EventSourcedAggregateRoot;

use Francken\Activities\Events\ActivityPlanned;
use Francken\Activities\Events\ActivityPublished;

use DateTime;

final class Activity extends EventSourcedAggregateRoot
{
    private $id;

    const SOCIAL = 'social';
    const CARREER = 'carreer';
    const EDUCATION = 'education';

    public static function plan(
        ActivityId $id,
        $name,
        $description,
        DateTime $time,
        Location $location,
        $type
    )
    {
        $activity = new Activity;

        $activity->apply(new ActivityPlanned($id, $name, $description, $time, $location, $type));

        return $activity;
    }

    public function publish()
    {
        $this->apply(new ActivityPublished($this->id));
    }

    public function applyActivityPlanned(ActivityPlanned $event)
    {
        $this->id = $event->activityId();
    }

    public function getAggregateRootId()
    {
        return $this->id;
    }

}