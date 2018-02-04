<?php

declare(strict_types=1);

namespace Francken\Tests\Application\Committees;

use Francken\Tests\Application\ReadModelTestCase as TestCase;
use Francken\Application\Committees\CommitteesList;
use Francken\Domain\Members\MemberId;
use Francken\Domain\Members\Email;
use Francken\Domain\Committees\CommitteeId;

class CommitteesListTest extends TestCase
{
    /** @test */
    function it_has_a_list_of_members()
    {
        $id = CommitteeId::generate();
        $committee = new CommitteesList($id, 'S[ck]rip(t|t?c)ie', 'Digital anarchy');

        $this->assertEmpty($committee->members());
    }

    /** @test */
    function a_member_can_be_added_to_a_committee()
    {
        $id = CommitteeId::generate();
        $committee = new CommitteesList($id, 'S[ck]rip(t|t?c)ie', 'Digital anarchy');
        $member = MemberId::generate();
        $committee = $committee->addMember(
            $member,
            "Mark",
            "Redeman"
        );

        $this->assertEquals([
            [
                "id" => (string)$member,
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
        $committee = $committee->addMember(
            $member,
            "Mark",
            "Redeman"
        );
        $committee = $committee->removeMember($member);

        $this->assertEquals([], $committee->members());
    }

    /** @test */
    function the_name_of_a_committee_can_be_changed()
    {
        $id = CommitteeId::generate();
        $committee = new CommitteesList($id, 'S[ck]rip(t|t?c)ie', 'Digital anarchy');
        $committee = $committee->changeName('compucie');
        $this->assertEquals('compucie', $committee->name());
    }

    /** @test */
    function the_summary_of_a_committee_can_be_changed()
    {
        $id = CommitteeId::generate();
        $committee = new CommitteesList($id, 'S[ck]rip(t|t?c)ie', 'Digital anarchy');
        $committee = $committee->changeGoal('Markt verovering');
        $this->assertEquals('Markt verovering', $committee->summary());
    }

    /** @test */
    function the_email_of_a_committee_can_be_changed()
    {
        $id = CommitteeId::generate();
        $committee = new CommitteesList($id, 'S[ck]rip(t|t?c)ie', 'Digital anarchy');
        $committee = $committee->changeEmail(new Email('scriptcie@professorfrancken.nl'));
        $this->assertEquals(new Email('scriptcie@professorfrancken.nl'), $committee->email());
        $committee = $committee->changeEmail(null);
        $this->assertEquals(null, $committee->email());
    }

    /** @test */
    function the_committee_page_can_be_changed()
    {
        $id = CommitteeId::generate();
        $committee = new CommitteesList($id, 'S[ck]rip(t|t?c)ie', 'Digital anarchy');
        $committee = $committee->changeCommitteePage('# Title', '<h1>Title</h1>');
        $this->assertEquals('# Title', $committee->markDown());
        $this->assertEquals('<h1>Title</h1>', $committee->html());
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
