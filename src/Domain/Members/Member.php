<?php

namespace Francken\Domain\Members;

use Francken\Domain\AggregateRoot;
use Francken\Domain\Members\Events\MemberJoinedFrancken;
use Francken\Domain\Members\MemberId;

class Member extends AggregateRoot
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
