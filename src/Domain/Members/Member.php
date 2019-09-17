<?php

declare(strict_types=1);

namespace Francken\Domain\Members;

use Francken\Domain\AggregateRoot;
use Francken\Domain\Members\Events\MemberJoinedFrancken;

class Member extends AggregateRoot
{
    private $id;
    private $first_name;
    private $last_name;

    public static function instantiate(MemberId $id, $first_name, $last_name)
    {
        $member = new self();
        $member->apply(new MemberJoinedFrancken($id, $first_name, $last_name));
        return $member;
    }

    public function applyMemberJoinedFrancken(MemberJoinedFrancken $event) : void
    {
        $this->id = $event->memberId();
        $this->first_name = $event->firstName();
        $this->last_name = $event->lastName();
    }

    public function getAggregateRootId() : string
    {
        return (string)$this->id;
    }
}
