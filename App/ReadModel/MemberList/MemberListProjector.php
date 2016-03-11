<?php

namespace App\ReadModel\MemberList;

use App\ReadModel\MemberList\MemberList;

use Broadway\ReadModel\Projector;

use Francken\Members\Events\MemberJoinedFrancken;
use Francken\Committees\Events\CommitteeInstantiated;

final class MemberListProjector extends Projector
{
    public function applyMemberJoinedFrancken(MemberJoinedFrancken $event)
    {
        $member = new MemberList;
        $member->uuid = $event->memberId();
        $member->first_name = $event->firstName();
        $member->last_name = $event->lastName();

        $member->save();
    }
}
