<?php

namespace Francken\Application\ReadModel\CommitteesList;

use Francken\Application\Projector;
use Francken\Application\ReadModel\CommitteesList\CommitteesList;
use Francken\Application\ReadModel\MemberList\MemberList;
use Francken\Domain\Committees\Events\CommitteeGoalChanged;
use Francken\Domain\Committees\Events\CommitteeInstantiated;
use Francken\Domain\Committees\Events\CommitteeNameChanged;
use Francken\Domain\Committees\Events\MemberJoinedCommittee;
use Francken\Domain\Committees\Events\MemberLeftCommittee;

final class CommitteesListProjector extends Projector
{
    public function whenCommitteeInstantiated(CommitteeInstantiated $event)
    {
        $committee = new CommitteesList;
        $committee->uuid = $event->committeeId();
        $committee->name = $event->name();
        $committee->goal = $event->goal();
        $committee->committee_members = [];

        $committee->save();
    }

    public function whenCommitteeNameChanged(CommitteeNameChanged $event)
    {
        CommitteesList::where('uuid', $event->committeeId())
            ->update(['name' => $event->name()]);
    }

    public function whenCommitteeGoalChanged(CommitteeGoalChanged $event)
    {
        CommitteesList::where('uuid', $event->committeeId())
            ->update(['goal' => $event->goal()]);
    }

    public function whenMemberJoinedCommittee(MemberJoinedCommittee $event)
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

    public function whenMemberLeftCommittee(MemberLeftCommittee $event)
    {
        $committee = CommitteesList::where('uuid', $event->committeeId())->first();
        $members = $committee->committee_members;

        foreach ($members as $key => $member) {
            if ($member['uuid'] === (string) $event->memberId()) {
                unset($members[$key]);
            }
        }

        $committee->committee_members = $members;
        $committee->save();
    }
}
