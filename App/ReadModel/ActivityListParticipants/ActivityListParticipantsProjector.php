<?php

namespace App\ReadModel\CommitteesList;

use App\ReadModel\ActivityListParticipant;

use Broadway\ReadModel\Projector;

use Francken\Activity\Events\ActivityPlanned;
use Francken\Activity\Events\ActivityPublished;
use Francken\Activity\Events\ActivityCategorized;
use Francken\Activity\Events\ActivityCancelled;

final class ActivitiesListParticipantsProjector extends Projector
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
