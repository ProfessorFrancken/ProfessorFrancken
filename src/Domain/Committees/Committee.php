<?php

namespace Francken\Domain\Committees;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Francken\Domain\Members\MemberId;
use Francken\Domain\Committees\CommitteeId;
use Francken\Domain\Committees\Events\CommitteeInstantiated;
use Francken\Domain\Committees\Events\CommitteeNameChanged;
use Francken\Domain\Committees\Events\CommitteeGoalChanged;
use Francken\Domain\Committees\Events\MemberJoinedCommittee;
use Francken\Domain\Committees\Events\MemberLeftCommittee;

class Committee extends EventSourcedAggregateRoot
{
    private $id;
    private $name;
    private $goal;
    private $members = [];

    public static function instantiate(CommitteeId $id, $name, $goal) : Committee
    {
        $committee = new Committee;

        $committee->apply(new CommitteeInstantiated($id, $name, $goal));

        return $committee;
    }

    public function edit($name, $goal)
    {
        if (isset($name) and $name != $this->name) {
            $this->apply(new CommitteeNameChanged($this->id, $name));
        }

        if (isset($goal) and $goal != $this->goal) {
            $this->apply(new CommitteeGoalChanged($this->id, $goal));
        }
    }

    public function joinByMember(MemberId $memberId)
    {
        if ($this->memberIsInCommittee($memberId)) {
            return;
        }

        $this->apply(new MemberJoinedCommittee($this->id, $memberId));
    }

    public function leftByMember(MemberId $memberId)
    {
        if (! $this->memberIsInCommittee($memberId)) {
            return;
        }

        $this->apply(new MemberLeftCommittee($this->id, $memberId));
    }

    public function getAggregateRootId() : CommitteeId
    {
        return $this->id;
    }

    protected function applyCommitteeInstantiated(CommitteeInstantiated $event)
    {
        $this->id = $event->committeeId();
        $this->name = $event->name();
        $this->goal = $event->goal();
    }

    protected function applyCommitteeNameChanged(CommitteeNameChanged $event)
    {
        $this->name = $event->name();
    }

    protected function applyCommitteeGoalChanged(CommitteeGoalChanged $event)
    {
        $this->goal = $event->goal();
    }

    protected function applyMemberJoinedCommittee(MemberJoinedCommittee $event)
    {
        $this->members[] =  $event->memberId();
    }

    protected function applyMemberLeftCommittee(MemberLeftCommittee $event)
    {
        unset($this->members[array_search($event->memberId(), $this->members)]);
    }

    private function memberIsInCommittee(MemberId $memberId) : bool
    {
        return in_array($memberId, $this->members);
    }
}
