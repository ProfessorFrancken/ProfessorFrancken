<?php

namespace Francken\Application\ReadModel\CommitteesList;

use Francken\Application\Projector;
use Francken\Application\ReadModel\ActivityListParticipant;
use Francken\Domain\Activity\Events\ActivityCancelled;
use Francken\Domain\Activity\Events\ActivityCategorized;
use Francken\Domain\Activity\Events\ActivityPlanned;
use Francken\Domain\Activity\Events\ActivityPublished;

final class ActivityListParticipantsProjector extends Projector
{
    public function whenActivityPlanned(ActivityPlanned $event)
    {
        ActivityListParticipant::create([
            'uuid' => $event->ActivityId(),
            'name' => $event->name(),
            'description' => $event->description(),
            'date-time' => $event->time(),
            'location' => $event->location(),
            'type' => $event->type()
        ]);
    }

    public function whenActivityPublished(ActivityPublished $event)
    {
        ActivityListParticipant::find($event->ActivityId())
            ->update([
                'published' => 1
            ]);
    }

    public function whenActivityCategorized(ActivityCategorized $event)
    {
        ActivityListParticipant::find($event->ActivityId())
            ->update([
                'category' => $event->category()
            ]);
    }

    public function whenActivityCancelled(ActivityCancelled $event)
    {
        ActivityListParticipant::find($event->ActivityId())
            ->update([
                'category' => 0
            ]);
    }

    public function whenMemberRegisteredToParticipate(MemberRegisteredToParticipate $event)
    {
        $activity = ActivityListParticipant::find($event->ActivityId());
        $activity->addParticipant($event->memberId());
    }
}
