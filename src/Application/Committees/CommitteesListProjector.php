<?php

declare(strict_types=1);

namespace Francken\Application\Committees;

use Francken\Application\Projector;
use Francken\Application\ReadModel\MemberList\MemberListRepository;
use Francken\Domain\Committees\Events\CommitteeEmailChanged;
use Francken\Domain\Committees\Events\CommitteeGoalChanged;
use Francken\Domain\Committees\Events\CommitteeInstantiated;
use Francken\Domain\Committees\Events\CommitteeNameChanged;
use Francken\Domain\Committees\Events\CommitteePageChanged;
use Francken\Domain\Committees\Events\MemberJoinedCommittee;
use Francken\Domain\Committees\Events\MemberLeftCommittee;
use League\CommonMark\CommonMarkConverter;

final class CommitteesListProjector extends Projector
{
    private $members;
    private $committees;
    private $markDownConverter;

    public function __construct(
        CommitteesListRepository $committees,
        MemberListRepository $members,
        CommonMarkConverter $markDownConverter
    ) {
        $this->members = $members;
        $this->committees = $committees;
        $this->markDownConverter = $markDownConverter;
    }

    public function whenCommitteeInstantiated(CommitteeInstantiated $event) : void
    {
        $committee = new CommitteesList(
            $event->committeeId(),
            $event->name(),
            $event->goal()
        );

        $this->committees->save($committee);
    }

    public function whenCommitteeEmailChanged(CommitteeEmailChanged $event) : void
    {
        $committee = $this->committees->find($event->committeeId());
        $committee = $committee->changeEmail($event->email());

        $this->committees->save($committee);
    }

    public function whenCommitteePageChanged(CommitteePageChanged $event) : void
    {
        $committee = $this->committees->find($event->committeeId());
        $committee = $committee->changeCommitteePage(
            $event->page(),
            $this->markDownConverter->convertToHtml($event->page())
        );

        $this->committees->save($committee);
    }

    public function whenCommitteeNameChanged(CommitteeNameChanged $event) : void
    {
        $committee = $this->committees->find($event->committeeId());
        $committee = $committee->changeName($event->name());

        $this->committees->save($committee);
    }

    public function whenCommitteeGoalChanged(CommitteeGoalChanged $event) : void
    {
        $committee = $this->committees->find($event->committeeId());
        $committee = $committee->changeGoal($event->goal());

        $this->committees->save($committee);
    }

    public function whenMemberJoinedCommittee(MemberJoinedCommittee $event) : void
    {
        $committee = $this->committees->find($event->committeeId());
        $member = $this->members->find($event->memberId());

        $committee = $committee->addMember(
            $member->memberId(),
            $member->firstName(),
            $member->lastName()
        );

        $this->committees->save($committee);
    }

    public function whenMemberLeftCommittee(MemberLeftCommittee $event) : void
    {
        $committee = $this->committees->find($event->committeeId());
        $committee = $committee->removeMember($event->memberId());

        $this->committees->save($committee);
    }
}
