<?php

namespace Francken\Application\ReadModel\CommitteesList;

use Francken\Application\ReadModel\ActivityListParticipant;
use Broadway\ReadModel\Projector;
use Francken\Domain\Activity\Events\ActivityPlanned;
use Francken\Domain\Activity\Events\ActivityPublished;
use Francken\Domain\Activity\Events\ActivityCategorized;
use Francken\Domain\Activity\Events\ActivityCancelled;

final class ActivityListParticipantsProjector extends Projector
{
    public function applyActivityPlanned(ActivityPlanned $event)
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

    public function applyActivityPublished(ActivityPublished $event)
    {
        ActivityListParticipant::find($event->ActivityId())
            ->update([
                'published' => 1
            ]);
    }

    public function applyActivityCategorized(ActivityCategorized $event)
    {
        ActivityListParticipant::find($event->ActivityId())
            ->update([
                'category' => $event->category()
            ]);
    }

    public function applyActivityCancelled(ActivityCancelled $event)
    {
        ActivityListParticipant::find($event->ActivityId())
            ->update([
                'category' => 0
            ]);
    }

    public function applyMemberRegisteredToParticipate(MemberRegisteredToParticipate $event)
    {
        $activity = ActivityListParticipant::find($event->ActivityId());
        $activity->addParticipant($event->memberId());
    }
}
