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
            ->see($oldCommittee->name);
    }

    /** @test */
    public function it_updates_a_member() : void
    {
        $member = factory(LegacyMember::class)->create();
        factory(Board::class)->create();

        $this->visit(action([MembersController::class, 'edit'], ['member' => $member]))
            ->see($member->voornaam)
            ->see($member->achternaam)
            ->check('erelid')
            ->check("nederlands")
            ->check("is_nederland")
            ->check("machtiging")
            ->check("gratis_lidmaatschap")
            ->check("is_lid")
            ->check("afgestudeerd")
            ->check("wanbetaler")
            ->check("mailinglist_franckenvrij")
            ->check("mailinglist_email")
            ->check("mailinglist_post")
            ->check("mailinglist_sms")
            ->check("mailinglist_constitutiekaart")
            ->check("mailinglist_franckenvrij")
            ->type('NL91 ABNA 0417 1643 00', 'rekeningnummer')
            ->select('male', 'gender')
            ->type('John', 'voornaam')
            ->type('Snow', 'achternaam')
            ->press('Save');

        $member->refresh();
        $this->assertEquals('John', $member->voornaam);
        $this->assertEquals('Snow', $member->achternaam);
    }

    /** @test */
    public function it_keeps_a_members_previous_data() : void
    {
        $member = factory(LegacyMember::class)->create();
        factory(Board::class)->create();

        $oldData =$member->toArray();
        $this->visit(action([MembersController::class, 'edit'], ['member' => $member]))
            ->type('', 'rekeningnummer')
            ->press('Save');

        $member->refresh();
        $newData = $member->toArray();
        foreach ($oldData as $key => $data) {
            if (in_array($key, ['rekeningnummer', 'updated_at'], true)) {
                continue;
            }
            $this->assertEquals($data, $newData[$key], "Did not keep the same value for ${key}");
        }
    }
}
