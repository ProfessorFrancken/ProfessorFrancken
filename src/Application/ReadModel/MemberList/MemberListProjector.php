<?php

namespace Francken\Application\ReadModel\MemberList;

use Francken\Application\ReadModel\MemberList\MemberList;
use Broadway\ReadModel\Projector;
use Francken\Domain\Members\Events\MemberJoinedFrancken;
use Francken\Domain\Committees\Events\CommitteeInstantiated;

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
