<?php

declare(strict_types=1);

namespace Francken\Domain\Committees;

use Francken\Domain\AggregateRoot;
use Francken\Domain\Committees\CommitteeId;
use Francken\Domain\Committees\Events\CommitteeGoalChanged;
use Francken\Domain\Committees\Events\CommitteeInstantiated;
use Francken\Domain\Committees\Events\CommitteeNameChanged;
use Francken\Domain\Committees\Events\MemberJoinedCommittee;
use Francken\Domain\Committees\Events\MemberLeftCommittee;
use Francken\Domain\Committees\Events\CommitteeEmailChanged;
use Francken\Domain\Committees\Events\CommitteePageChanged;
use Francken\Domain\Members\MemberId;
use Francken\Domain\Members\Email;

class Committee extends AggregateRoot
{
    private $id;
    private $name;
    private $summary;
    private $email = null;
    private $webPage = "";
    private $members = []; // array of memberId's

    public static function instantiate(CommitteeId $id, string $name, string $summary) : Committee
    {
        $committee = new Committee;
        $committee->apply(new CommitteeInstantiated($id, $name, $summary));
        return $committee;
    }

    public function setEmail(Email $email = null)
    {
        if ($email != $this->email) {
            $this->apply(new CommitteeEmailChanged($this->id, $email));
        }
    }

    public function setCommitteePage(string $markDown)
    {
        if ($markDown != $this->webPage) {
            $this->apply(new CommitteePageChanged($this->id, $markDown));
        }
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

    protected function applyCommitteeEmailChanged(CommitteeEmailChanged $event)
    {
        $this->email = $event->email();
    }

    protected function applyCommitteePageChanged(CommitteePageChanged $event)
    {
        $this->email = $event->page();
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
