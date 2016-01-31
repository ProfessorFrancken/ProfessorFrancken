<?php

namespace Tests\Francken\Committees;

use Broadway\EventSourcing\Testing\AggregateRootScenarioTestCase;
use Broadway\UuidGenerator\Rfc4122\Version4Generator;

use Francken\Committees\Committee;
use Francken\Committees\CommitteeId;
use Francken\Committees\Events\CommitteeInstantiated;

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
    public function a_committee_has_members()
    {
        $id = new CommitteeId($this->generator->generate());
        $memberId = $this->generator->generate();

        $this->scenario
            ->withAggregateId($id)
            ->given([new CommitteeInstantiated($id, 'S[ck]rip(t|t?c)ie', 'Digital anarchy')])
            ->when(function ($committee) use ($memberId) {
                $committee->joinByMember($memberId);
            })
            ->then([new CommitteeMemberJoined($id, $memberId)]);
    }
}
