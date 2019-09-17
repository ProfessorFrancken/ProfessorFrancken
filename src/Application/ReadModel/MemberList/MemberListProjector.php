<?php

declare(strict_types=1);

namespace Francken\Application\ReadModel\MemberList;

use Francken\Application\Projector;
use Francken\Domain\Members\Events\MemberJoinedFrancken;

final class MemberListProjector extends Projector
{
    private $members;

    public function __construct(MemberListRepository $members)
    {
        $this->members = $members;
    }

    public function whenMemberJoinedFrancken(MemberJoinedFrancken $event) : void
    {
        $member = new MemberList(
            $event->memberId(),
            $event->firstName(),
            $event->lastName()
        );

        $this->members->save($member);
    }
}
