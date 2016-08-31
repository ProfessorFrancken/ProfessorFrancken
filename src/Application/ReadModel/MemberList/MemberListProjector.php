<?php

namespace Francken\Application\ReadModel\MemberList;

use Francken\Application\Projector;
use Francken\Application\ReadModel\MemberList\MemberList;
use Francken\Domain\Members\Events\MemberJoinedFrancken;
use Francken\Application\ReadModelRepository as Repository;

final class MemberListProjector extends Projector
{
    private $members;

    public function __construct(Repository $members)
    {
        $this->members = $members;
    }

    public function whenMemberJoinedFrancken(MemberJoinedFrancken $event)
    {
        $member = new MemberList(
            $event->memberId(),
            $event->firstName(),
            $event->lastName()
        );

        $this->members->save($member);
    }
}
