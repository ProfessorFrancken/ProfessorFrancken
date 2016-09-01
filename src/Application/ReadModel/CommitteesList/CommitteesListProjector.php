<?php

namespace Francken\Application\ReadModel\CommitteesList;

use Francken\Application\Projector;
use Francken\Application\ReadModelRepository as Repository;
use Francken\Application\ReadModel\MemberList\MemberList;
use Francken\Domain\Committees\Events\CommitteeGoalChanged;
use Francken\Domain\Committees\Events\CommitteeInstantiated;
use Francken\Domain\Committees\Events\CommitteeNameChanged;
use Francken\Domain\Committees\Events\MemberJoinedCommittee;
use Francken\Domain\Committees\Events\MemberLeftCommittee;

final class CommitteesListProjector extends Projector
{
    private $members;
    private $committees;

    public function __construct(Repository $committees, Repository $members)
    {
        $this->members = $members;
        $this->committees = $committees;
    }

    public function whenCommitteeInstantiated(CommitteeInstantiated $event)
    {
        $committee = new CommitteesList(
            $event->committeeId(),
            $event->name(),
            $event->goal()
        );

        $this->committees->save($committee);
    }

    public function whenCommitteeNameChanged(CommitteeNameChanged $event)
    {
        $committee = $this->committees->find((string)$event->committeeId());
        $committee = $committee->changeName($event->name());

        $this->committees->save($committee);
    }

    public function whenCommitteeGoalChanged(CommitteeGoalChanged $event)
    {
        $committee = $this->committees->find((string)$event->committeeId());
        $committee = $committee->changeGoal($event->goal());

        $this->committees->save($committee);
    }

    public function whenMemberJoinedCommittee(MemberJoinedCommittee $event)
    {
        $committee = $this->committees->find((string)$event->committeeId());
        $member = $this->members->find($event->memberId());

        $committee = $committee->addMember(
            $member->memberId(),
            $member->firstName(),
            $member->lastName()
        );

        $this->committees->save($committee);
    }

    public function whenMemberLeftCommittee(MemberLeftCommittee $event)
    {
        $committee = $this->committees->find((string)$event->committeeId());
        $committee = $committee->removeMember($event->memberId());

        $this->committees->save($committee);
    }
}
