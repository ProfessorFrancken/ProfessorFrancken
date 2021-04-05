<?php


declare(strict_types=1);

namespace Francken\Features\Admin\Association;

use DateTimeImmutable;
use Francken\Association\Boards\Board;
use Francken\Association\Committees\Committee;
use Francken\Association\Committees\CommitteeMember;
use Francken\Association\LegacyMember;
use Francken\Association\Members\Http\Controllers\Admin\MembersController;
use Francken\Features\LoggedInAsAdmin;
use Francken\Features\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MembersFeature extends TestCase
{
    use LoggedInAsAdmin;
    use DatabaseTransactions;

    /** @test */
    public function it_shows_members() : void
    {
        $today = new DateTimeImmutable();

        $newMember = factory(LegacyMember::class)->create();
        $activeMember = factory(LegacyMember::class)->create([
            'created_at' => $today->modify('-2 years'),
        ]);
        $currentActiveMember = factory(LegacyMember::class)->create([
            'created_at' => $today->modify('-2 years'),
        ]);
        $cancelledMembership = factory(LegacyMember::class)->create([
            'created_at' => $today->modify('-2 years'),
            'einde_lidmaatschap' => $today,
        ]);

        $previousBoard = factory(Board::class)->create();
        $currentBoard = factory(Board::class)->create([
            'installed_at' => $previousBoard->installed_at->modify("+1 year")->format("Y-m-d")
        ]);
        $oldCommittee = factory(Committee::class)->create(['board_id' => $previousBoard->id]);
        $currentCommittee = factory(Committee::class)->create(['board_id' => $currentBoard->id]);

        factory(CommitteeMember::class)->create([
            'committee_id' => $oldCommittee->id,
            'member_id' => $activeMember->id,
        ]);

        factory(CommitteeMember::class)->create([
            'committee_id' => $currentCommittee->id,
            'member_id' => $currentActiveMember->id,
        ]);


        $this->visit(action([MembersController::class, 'index']))
            ->see('Members')
            ->see($newMember->fullname)
            ->see($activeMember->fullname)
            ->see($currentActiveMember->fullname)
            ->see($cancelledMembership->fullname)
            ->see("All members")
            ->see("New members")
            ->see("Current active members")
            ->see("Active members")
            ->see("Cancelled membership")
            ->click('New members')
            ->see($newMember->fullname)
            ->dontsee($activeMember->fullname)
            ->dontsee($currentActiveMember->fullname)
            ->dontsee($cancelledMembership->fullname)
            ->click('Current active members')
            ->dontsee($newMember->fullname)
            ->dontsee($activeMember->fullname)
            ->see($currentActiveMember->fullname)
            ->dontsee($cancelledMembership->fullname)
            ->click('Active members')
            ->dontsee($newMember->fullname)
            ->see($activeMember->fullname)
            ->see($currentActiveMember->fullname)
            ->dontsee($cancelledMembership->fullname)
            ->click('Cancelled membership')
            ->dontsee($newMember->fullname)
            ->dontsee($activeMember->fullname)
            ->dontsee($currentActiveMember->fullname)
            ->see($cancelledMembership->fullname);


        $this->visit(action([MembersController::class, 'index']))
            ->type($newMember->voornaam, 'firstname')
            ->type($newMember->achternaam, 'surname')
            ->type($newMember->emailadres, 'email')
            ->select($newMember->studierichting, 'study')
            ->select($newMember->type_lid, 'type')
            ->press('Apply filters')
            ->see($newMember->fullname);
    }

    /** @test */
    public function it_shows_a_members_information() : void
    {
        $member = factory(LegacyMember::class)->create();

        $previousBoard = factory(Board::class)->create();
        $currentBoard = factory(Board::class)->create([
            'installed_at' => $previousBoard->installed_at->modify("+1 year")->format("Y-m-d")
        ]);
        $oldCommittee = factory(Committee::class)->create(['board_id' => $previousBoard->id]);
        $currentCommittee = factory(Committee::class)->create(['board_id' => $currentBoard->id]);

        factory(CommitteeMember::class)->create([
            'committee_id' => $oldCommittee->id,
            'member_id' => $member->id,
        ]);

        factory(CommitteeMember::class)->create([
            'committee_id' => $currentCommittee->id,
            'member_id' => $member->id,
        ]);


        $this->visit(action([MembersController::class, 'show'], ['member' => $member]))
            ->see($member->voornaam)
            ->see($member->achternaam)
            ->see($currentBoard->board_name->toString())
            ->see($previousBoard->board_name->toString())
            ->see($currentCommittee->name)
            ->see($oldCommittee->name)
                                                                          ;
    }
}
