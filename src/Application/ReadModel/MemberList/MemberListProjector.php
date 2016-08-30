<?php

namespace Francken\Application\ReadModel\MemberList;

use Francken\Application\Projector;
use Francken\Application\ReadModel\MemberList\MemberList;
use Francken\Domain\Committees\Events\CommitteeInstantiated;
use Francken\Domain\Members\Events\MemberJoinedFrancken;

final class MemberListProjector extends Projector
{
    public function whenMemberJoinedFrancken(MemberJoinedFrancken $event)
    {
        $member = new MemberList;
        $member->uuid = $event->memberId();
        $member->first_name = $event->firstName();
        $member->last_name = $event->lastName();

        $member->save();
    }
}
