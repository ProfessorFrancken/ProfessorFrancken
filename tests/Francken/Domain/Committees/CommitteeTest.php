<?php

declare(strict_types=1);

namespace Tests\Francken\Committees;

use Francken\Domain\Committees\Committee;
use Francken\Domain\Committees\CommitteeId;
use Francken\Domain\Committees\Events\CommitteeEmailChanged;
use Francken\Domain\Committees\Events\CommitteeGoalChanged;
use Francken\Domain\Committees\Events\CommitteeInstantiated;
use Francken\Domain\Committees\Events\CommitteeNameChanged;
use Francken\Domain\Committees\Events\CommitteePageChanged;
use Francken\Domain\Committees\Events\MemberJoinedCommittee;
use Francken\Domain\Members\Email;
use Francken\Domain\Members\MemberId;
use Francken\Tests\AggregateRootScenarioTestCase;

class CommitteeTest extends AggregateRootScenarioTestCase
{
    /**
     * @test
     */
    public function it_is_intantiated_with_a_name_and_a_goal() : void
    {
        $id = CommitteeId::generate();

        $this->scenario
            ->when(function () use ($id) {
                return Committee::instantiate($id, 'S[ck]rip(t|t?c)ie', 'Digital anarchy');
            })
            ->then([new CommitteeInstantiated($id, 'S[ck]rip(t|t?c)ie', 'Digital anarchy')]);
    }

    /**
     * @test
     */
    public function a_committee_email_can_be_set() : void
    {
        $id = CommitteeId::generate();

        $this->scenario
            ->given([new CommitteeInstantiated($id, 'S[ck]rip(t|t?c)ie', 'Digital anarchy')])
            ->when(function ($committee) use ($id) : void {
                $committee->setEmail(new Email('scriptcie@professorfrancken.nl'));
            })
            ->then([new CommitteeEmailChanged($id, new Email('scriptcie@professorfrancken.nl'))]);
    }

    /**
     * @test
     */
    public function a_committee_email_can_be_unset() : void
    {
        $id = CommitteeId::generate();

        $this->scenario
            ->given([new CommitteeInstantiated($id, 'S[ck]rip(t|t?c)ie', 'Digital anarchy'),
                new CommitteeEmailChanged($id, new Email('scriptcie@professorfrancken.nl'))])
            ->when(function ($committee) use ($id) : void {
                $committee->setEmail(null);
            })
            ->then([new CommitteeEmailChanged($id, null)]);
    }

    /**
     * @test
     */
    public function a_committee_web_page_can_be_set() : void
    {
        $id = CommitteeId::generate();

        $this->scenario
            ->given([new CommitteeInstantiated($id, 'S[ck]rip(t|t?c)ie', 'Digital anarchy')])
            ->when(function ($committee) use ($id) : void {
                $committee->setCommitteePage('# Title');
            })
            ->then([new CommitteePageChanged($id, '# Title')]);
    }

    /**
     * @test
     */
    public function a_committees_name_can_be_changed() : void
    {
        $id = CommitteeId::generate();

        $this->scenario
            ->given([new CommitteeInstantiated($id, 'S[ck]rip(t|t?c)ie', 'Digital anarchy')])
            ->when(function ($committee) use ($id) : void {
                $committee->edit('Borrelcie', 'Digital anarchy');
            })
            ->then([new CommitteeNameChanged($id, 'Borrelcie')]);
    }

    /**
     * @test
     */
    public function a_committees_goal_can_be_changed() : void
    {
        $id = CommitteeId::generate();

        $this->scenario
            ->given([new CommitteeInstantiated($id, 'S[ck]rip(t|t?c)ie', 'Digital anarchy')])
            ->when(function ($committee) use ($id) : void {
                $committee->edit('S[ck]rip(t|t?c)ie', 'CenC organiseren');
            })
            ->then([new CommitteeGoalChanged($id, 'CenC organiseren')]);
    }

    /**
     * @test
     */
    public function a_committees_can_be_edited() : void
    {
        $id = CommitteeId::generate();

        $this->scenario
            ->given([new CommitteeInstantiated($id, 'S[ck]rip(t|t?c)ie', 'Digital anarchy')])
            ->when(function ($committee) use ($id) : void {
                $committee->edit('Borrelcie', 'bier drinken');
            })
            ->then([
                new CommitteeNameChanged($id, 'Borrelcie'),
                new CommitteeGoalChanged($id, 'bier drinken')
            ]);
    }

    /**
     * @test
     */
    public function a_committee_has_members() : void
    {
        $id = CommitteeId::generate();
        $memberId = MemberId::generate();

        $this->scenario
            ->withAggregateId((string)$id)
            ->given([new CommitteeInstantiated($id, 'S[ck]rip(t|t?c)ie', 'Digital anarchy')])
            ->when(function ($committee) use ($memberId) : void {
                $committee->joinByMember($memberId);
            })
            ->then([new MemberJoinedCommittee($id, $memberId)])
            //
            // A member can't join a committee twice
            //
            ->when(function ($committee) use ($memberId) : void {
                $committee->joinByMember($memberId);
            })
            ->then([]);
    }

    protected function getAggregateRootClass() : string
    {
        return Committee::class;
    }
}
