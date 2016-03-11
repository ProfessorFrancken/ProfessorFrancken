<?php

namespace App\ReadModel\CommitteesList;

use App\ReadModel\CommitteesList\CommitteesList;
use App\ReadModel\MemberList\MemberList;

use Broadway\ReadModel\Projector;

use Francken\Committees\Events\CommitteeInstantiated;
use Francken\Committees\Events\CommitteeNameChanged;
use Francken\Committees\Events\CommitteeGoalChanged;
use Francken\Committees\Events\MemberJoinedCommittee;
use Francken\Committees\Events\MemberLeftCommittee;



final class CommitteesListProjector extends Projector
{
    public function applyCommitteeInstantiated(CommitteeInstantiated $event)
    {
        $committee = new CommitteesList;
        $committee->uuid = $event->committeeId();
        $committee->name = $event->name();
        $committee->goal = $event->goal();
        $committee->committee_members = [];

        $committee->save();
    }

    public function applyCommitteeNameChanged(CommitteeNameChanged $event)
    {
        CommitteesList::where('uuid', $event->committeeId())
            ->update(['name' => $event->name()]);
    }

    public function applyCommitteeGoalChanged(CommitteeGoalChanged $event)
    {
        CommitteesList::where('uuid', $event->committeeId())
            ->update(['goal' => $event->goal()]);
    }

    public function applyMemberJoinedCommittee(MemberJoinedCommittee $event)
    {
        $committee = CommitteesList::where('uuid', $event->committeeId())->first();
        $members = $committee->committee_members;

        $members[] = [
            'uuid' => (string) $event->memberId(),
            'first_name' => MemberList::where('uuid', $event->memberId())->first()->first_name,
            'last_name' => MemberList::where('uuid', $event->memberId())->first()->last_name
        ];

        $committee->committee_members = $members;
        $committee->save();
    }

    public function applyMemberLeftCommittee(MemberLeftCommittee $event)
    {
        $committee = CommitteesList::where('uuid', $event->committeeId())->first();
        $members = $committee->committee_members;

        foreach($members as $key => $member)
        {
            if( $member['uuid'] === (string) $event->memberId())
            {
                unset($members[$key]);
            }
        }

        $committee->committee_members = $members;
        $committee->save();
    }
}
