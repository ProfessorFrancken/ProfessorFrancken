<?php

declare(strict_types=1);

namespace Tests\Francken\Committees;

use Broadway\EventSourcing\Testing\AggregateRootScenarioTestCase;
use Francken\Domain\Committees\Committee;
use Francken\Domain\Committees\CommitteeId;
use Francken\Domain\Committees\Events\CommitteeInstantiated;
use Francken\Domain\Committees\Events\CommitteeNameChanged;
use Francken\Domain\Committees\Events\CommitteeGoalChanged;
use Francken\Domain\Committees\Events\MemberJoinedCommittee;
use Francken\Domain\Committees\Events\CommitteeEmailSet;
use Francken\Domain\Committees\Events\CommitteePageSet;
use Francken\Domain\Members\MemberId;
use Francken\Domain\Members\Email;

class CommitteeTest extends AggregateRootScenarioTestCase
{
    protected function getAggregateRootClass()
    {
        return Committee::class;
    }

    /**
     * @test
     */
    public function it_is_intantiated_with_a_name_and_a_goal()
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
    public function a_committee_email_can_be_set()
    {
        $id = CommitteeId::generate();

        $this->scenario
            ->given([new CommitteeInstantiated($id, 'S[ck]rip(t|t?c)ie', 'Digital anarchy')])
            ->when(function ($committee) use ($id) {
                $committee->setEmail(new Email('scriptcie@professorfrancken.nl'));
            })
            ->then([new CommitteeEmailSet($id, new Email('scriptcie@professorfrancken.nl'))]);
    }

    /**
     * @test
     */
    public function a_committee_email_can_be_unset()
    {
        $id = CommitteeId::generate();

        $this->scenario
            ->given([new CommitteeInstantiated($id, 'S[ck]rip(t|t?c)ie', 'Digital anarchy'),
                new CommitteeEmailSet($id, new Email('scriptcie@professorfrancken.nl'))])
            ->when(function ($committee) use ($id) {
                $committee->setEmail(null);
            })
            ->then([new CommitteeEmailSet($id, null)]);
    }

    /**
     * @test
     */
    public function a_committee_web_page_can_be_set()
    {
        $id = CommitteeId::generate();

        $this->scenario
            ->given([new CommitteeInstantiated($id, 'S[ck]rip(t|t?c)ie', 'Digital anarchy')])
            ->when(function ($committee) use ($id) {
                $committee->setCommitteePage('# Title');
            })
            ->then([new CommitteePageSet($id, '# Title')]);
    }

    /**
     * @test
     */
    public function a_committees_name_can_be_changed()
    {
        $id = CommitteeId::generate();

        $this->scenario
            ->given([new CommitteeInstantiated($id, 'S[ck]rip(t|t?c)ie', 'Digital anarchy')])
            ->when(function ($committee) use ($id) {
                $committee->edit('Borrelcie', 'Digital anarchy');
            })
            ->then([new CommitteeNameChanged($id, 'Borrelcie')]);
    }

    /**
     * @test
     */
    public function a_committees_goal_can_be_changed()
    {
        $id = CommitteeId::generate();

        $this->scenario
            ->given([new CommitteeInstantiated($id, 'S[ck]rip(t|t?c)ie', 'Digital anarchy')])
            ->when(function ($committee) use ($id) {
                $committee->edit('S[ck]rip(t|t?c)ie', 'CenC organiseren');
            })
            ->then([new CommitteeGoalChanged($id, 'CenC organiseren')]);
    }

    /**
     * @test
     */
    public function a_committees_can_be_edited()
    {
        $id = CommitteeId::generate();

        $this->scenario
            ->given([new CommitteeInstantiated($id, 'S[ck]rip(t|t?c)ie', 'Digital anarchy')])
            ->when(function ($committee) use ($id) {
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
    public function a_committee_has_members()
    {
        $id = CommitteeId::generate();
        $memberId = MemberId::generate();

        $this->scenario
            ->withAggregateId($id)
            ->given([new CommitteeInstantiated($id, 'S[ck]rip(t|t?c)ie', 'Digital anarchy')])
            ->when(function ($committee) use ($memberId) {
                $committee->joinByMember($memberId);
            })
            ->then([new MemberJoinedCommittee($id, $memberId)])
            //
            // A member can't join a committee twice
            //
            ->when(function ($committee) use ($memberId) {
                $committee->joinByMember($memberId);
            })
            ->then([]);
    }
}
