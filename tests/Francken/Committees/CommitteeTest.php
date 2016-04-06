<?php

namespace Tests\Francken\Committees;

use Broadway\EventSourcing\Testing\AggregateRootScenarioTestCase;
use Broadway\UuidGenerator\Rfc4122\Version4Generator;
use Francken\Committees\Committee;
use Francken\Committees\CommitteeId;
use Francken\Committees\Events\CommitteeInstantiated;
use Francken\Committees\Events\CommitteeNameChanged;
use Francken\Committees\Events\CommitteeGoalChanged;
use Francken\Committees\Events\MemberJoinedCommittee;
use Francken\Members\MemberId;

class CommitteeTest extends AggregateRootScenarioTestCase
{
    private $generator;

    public function setUp()
    {
        parent::setUp();

        // We will use this generator to generate valid UUIDs
        $this->generator = new Version4Generator();
    }

    protected function getAggregateRootClass()
    {
        return Committee::class;
    }

    /**
     * @test
     */
    public function it_is_intantiated_with_a_name_and_a_goal()
    {
        $id = new CommitteeId($this->generator->generate());

        $this->scenario
            ->when(function () use ($id) {
                return Committee::instantiate($id, 'S[ck]rip(t|t?c)ie', 'Digital anarchy');
            })
            ->then([new CommitteeInstantiated($id, 'S[ck]rip(t|t?c)ie', 'Digital anarchy')]);
    }

    /**
     * @test
     */
    public function a_committees_name_can_be_changed()
    {
        $id = new CommitteeId($this->generator->generate());

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
        $id = new CommitteeId($this->generator->generate());

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
        $id = new CommitteeId($this->generator->generate());

        $this->scenario
            ->given([new CommitteeInstantiated($id, 'S[ck]rip(t|t?c)ie', 'Digital anarchy')])
            ->when(function ($committee) use ($id) {
                $committee->edit('Borrelcie', 'bier drinken');
            })
            ->then([new CommitteeNameChanged($id, 'Borrelcie'),
                new CommitteeGoalChanged($id, 'bier drinken')]);
    }

    /**
     * @test
     */
    public function a_committee_has_members()
    {
        $id = new CommitteeId($this->generator->generate());
        $memberId = new MemberId($this->generator->generate());

        $this->scenario
            ->withAggregateId($id)
            ->given([new CommitteeInstantiated($id, 'S[ck]rip(t|t?c)ie', 'Digital anarchy')])
            ->when(function ($committee) use ($memberId) {
                $committee->joinByMember($memberId);
            })
            ->then([new MemberJoinedCommittee($id, $memberId)]);
    }

    /**
     * @test
     */
    public function a_committee_member_cannot_join_twice()
    {
        $id = new CommitteeId($this->generator->generate());
        $memberId = new MemberId($this->generator->generate());

        $this->scenario
            ->withAggregateId($id)
            ->given([
                new CommitteeInstantiated($id, 'S[ck]rip(t|t?c)ie', 'Digital anarchy'),
                new MemberJoinedCommittee($id, $memberId)
            ])
            ->when(function ($committee) use ($memberId) {
                $committee->joinByMember($memberId);
            })
            ->then([]);
    }
}
