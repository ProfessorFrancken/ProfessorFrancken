<?php

declare(strict_types=1);

namespace Francken\Tests\Application\Committees;

use Francken\Tests\Application\ReadModelTestCase as TestCase;
use Francken\Application\ReadModel\CommitteesList\CommitteesList;
use Francken\Domain\Members\MemberId;
use Francken\Domain\Committees\CommitteeId;

class CommitteesListTest extends TestCase
{
    /** @test */
    function it_has_a_list_of_members()
    {
        $id = CommitteeId::generate();
        $committee = new CommitteesList($id, 'S[ck]rip(t|t?c)ie', 'Digital anarchy');
    }

    /** @test */
    function a_member_can_be_added_to_a_committee()
    {
        $id = CommitteeId::generate();
        $committee = new CommitteesList($id, 'S[ck]rip(t|t?c)ie', 'Digital anarchy');
        $member = MemberId::generate();
        $committee->addMember(
            $member,
            "Mark",
            "Redeman"
        );

        $this->assertEquals([
            [
                "uuid" => (string)$member,
                "first_name" => "Mark",
                "last_name" => "Redeman"
            ]
        ], $committee->members());
    }

    /** @test */
    function a_member_can_be_removed_from_a_committee()
    {
        $id = CommitteeId::generate();
        $committee = new CommitteesList($id, 'S[ck]rip(t|t?c)ie', 'Digital anarchy');
        $member = MemberId::generate();
        $committee->addMember(
            $member,
            "Mark",
            "Redeman"
        );
        $committee->removeMember($member);

        $this->assertEquals([], $committee->members());
    }

    /** @test */
    function the_name_of_a_committee_can_be_changed()
    {
        $id = CommitteeId::generate();
        $committee = new CommitteesList($id, 'S[ck]rip(t|t?c)ie', 'Digital anarchy');
        $committee->changeName('compucie');
        $this->assertEquals('compucie', $committee->name());
    }

    /** @test */
    function the_goal_of_a_committee_can_be_changed()
    {
        $id = CommitteeId::generate();
        $committee = new CommitteesList($id, 'S[ck]rip(t|t?c)ie', 'Digital anarchy');
        $committee->changeGoal('Markt verovering');
        $this->assertEquals('Markt verovering', $committee->goal());
    }

    protected function createInstance()
    {
        return new CommitteesList(
            CommitteeId::generate(),
            'S[ck]rip(t|t?c)ie',
            'Digital anarchy'
        );
    }
}
