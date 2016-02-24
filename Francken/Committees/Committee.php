<?php

namespace Francken\Committees;

use Broadway\EventSourcing\EventSourcedAggregateRoot;

use Francken\Committees\Events\CommitteeInstantiated;

class Committee extends EventSourcedAggregateRoot
{
    private $id;
    private $name;
    private $goal;

    public static function instantiate(CommitteeId $id, $name, $goal)
    {
        $committee = new Committee;

        $committee->apply(new CommitteeInstantiated($id, $name, $goal));

        return $committee;
    }

    public function edit($id, $name, $goal)
    {
        if(isset($name) and $name != $this->name)
        {
            $committee->apply(new CommitteeNameChanged($id, $name));
        }

        if(isset($goal) and $goal != $this->goal)
        {
            $committee->apply(new CommitteeGoalChanged($id, $goal));
        }
    }

    public function joinByMember(MemberId $memberId)
    {
        $this->apply(new MemberJoinedCommittee($this->id, $memberId));
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
}
