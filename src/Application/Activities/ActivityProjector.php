<?php

namespace Francken\Application\Activities;

use Francken\Application\Projector;
use Francken\Application\ReadModelRepository as Repository;

use Francken\Domain\Activities\ActivityId;
use Francken\Application\Activities\Activity;
use Francken\Application\Activities\ActivityRepository;

// events:
use Francken\Domain\Activities\Events\ActivityCancelled;
use Francken\Domain\Activities\Events\ActivityCategorized;
use Francken\Domain\Activities\Events\ActivityPlanned;
use Francken\Domain\Activities\Events\ActivityPublished;
use Francken\Domain\Activities\Events\ActivityRescheduled;
use Francken\Domain\Activities\Events\MemberRegisteredToParticipate;

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

    public function whenActivityPublished(ActivityPublished $event)
    {
        $activity = $this->activities->find($event->activityId());
        $activity = $activity->setPublished();
        $this->activities->save($activity);
    }

    public function whenActivityCancelled(ActivityCancelled $event)
    {
        $this->activities->remove($event->activityId());
    }

    public function whenActivityCategorized(ActivityCategorized $event)
    {
        $activity = $this->activities->find($event->activityId());
        $activity = $activity->setCategory($event->category());
        $this->activities->save($activity);
    }

    public function whenActivityRescheduled(ActivityRescheduled $event)
    {
        $activity = $this->activities->find($event->activityId());
        $activity = $activity->setSchedule($event->schedule());
        $this->activities->save($activity);
    }

    public function whenMemberRegisteredToParticipate(MemberRegisteredToParticipate $event)
    {
        $activity = $this->activities->find($event->activityId());
        $activity = $activity->addMember($event->memberId());
        $this->activities->save($activity);
    }
}
