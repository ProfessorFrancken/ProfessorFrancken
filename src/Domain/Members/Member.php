<?php

namespace Francken\Domain\Members;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Francken\Domain\Members\MemberId;
use Francken\Domain\Members\Events\MemberJoinedFrancken;

class Member extends EventSourcedAggregateRoot
{
    private $id;
    private $first_name;
    private $last_name;

    public static function instantiate(MemberId $id, $first_name, $last_name)
    {
        $member = new Member;
        $member->apply(new MemberJoinedFrancken($id, $first_name, $last_name));
        return $member;
    }

    public function applyMemberJoinedFrancken(MemberJoinedFrancken $event)
    {
        $this->id = $event->memberId();
        $this->first_name = $event->firstName();
        $this->last_name = $event->lastName();
    }

    public function getAggregateRootId()
    {
        return $this->id;
    }
}
