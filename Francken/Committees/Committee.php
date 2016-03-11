<?php

namespace Francken\Committees;

use Broadway\EventSourcing\EventSourcedAggregateRoot;

use Francken\Members\MemberId;

use Francken\Committees\CommitteeId;
use Francken\Committees\Events\CommitteeInstantiated;
use Francken\Committees\Events\CommitteeNameChanged;
use Francken\Committees\Events\CommitteeGoalChanged;
use Francken\Committees\Events\MemberJoinedCommittee;
use Francken\Committees\Events\MemberLeftCommittee;

class Committee extends EventSourcedAggregateRoot
{
    private $id;
    private $name;
    private $goal;
    private $members = array();

    public static function instantiate(CommitteeId $id, $name, $goal)
    {
        $committee = new Committee;

        $committee->apply(new CommitteeInstantiated($id, $name, $goal));

        return $committee;
    }

    public function edit($name, $goal)
    {
        if(isset($name) and $name != $this->name)
        {
            $this->apply(new CommitteeNameChanged($this->id, $name));
        }

        if(isset($goal) and $goal != $this->goal)
        {
            $this->apply(new CommitteeGoalChanged($this->id, $goal));
        }
    }

    public function joinByMember(MemberId $memberId)
    {
        //TODO: Check  $memberId is a valid ID
        if( ! in_array($memberId, $this->members))
        {
            $this->apply(new MemberJoinedCommittee($this->id, $memberId));
        }
    }

    public function leftByMember(MemberId $memberId)
    {
        // if ( in_array($memberId, $this->members) )
        // {
            $this->apply(new MemberLeftCommittee($this->id, $memberId));
        // }
    }

    public function getAggregateRootId()
    {
        return $this->id;
    }

    public function applyCommitteeInstantiated(CommitteeInstantiated $event)
    {
        $this->id = $event->committeeId();
        $this->name = $event->name();
        $this->goal = $event->goal();
    }

    public function applyCommitteeNameChanged(CommitteeNameChanged $event)
    {
        $this->name = $event->name();
    }

    public function applyCommitteeGoalChanged(CommitteeGoalChanged $event)
    {
        $this->goal = $event->goal();
    }

    public function applyMemberJoinedCommittee(MemberJoinedCommittee $event)
    {
        $this->members[] =  $event->memberId();
    }

    public function applyMemberLeftCommittee(MemberLeftCommittee $event)
    {
        unset($this->members[array_search($event->memberId(), $this->members)]);
    }
}
