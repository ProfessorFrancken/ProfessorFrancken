<?php

declare(strict_types=1);

namespace Francken\Features\Association\Committees;

use Francken\Association\Boards\Board;
use Francken\Association\Committees\Committee;
use Francken\Association\Committees\CommitteeMember;
use Francken\Association\Committees\Exports\ActiveMembersListExport;
use Francken\Association\Committees\Http\AdminActiveMembersExportController;
use Francken\Association\LegacyMember;
use Francken\Features\LoggedInAsAdmin;
use Francken\Features\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Maatwebsite\Excel\Facades\Excel;

class AdminActiveMembersExportFeature extends TestCase
{
    use DatabaseMigrations;
    use LoggedInAsAdmin;

    /** @test */
    public function exporting_active_members_of_a_board() : void
    {
        $board = factory(Board::class)->create(['installed_at' => '2020-06-06']);
        $member = factory(LegacyMember::class)->create();
        factory(CommitteeMember::class)->create([
            'member_id' => $member->id,
            'committee_id' => factory(Committee::class)->create([
                'board_id' => $board->id
            ])
        ]);
        factory(CommitteeMember::class)->create([
            'member_id' => $member->id,
            'committee_id' => factory(Committee::class)->create([
                'board_id' => $board->id
            ])
        ]);

        Excel::fake();

        $this->get(
            action(
                [AdminActiveMembersExportController::class, 'index'],
                ['board' => $board]
            )
        );

        Excel::assertDownloaded('active-members.xlsx', function (ActiveMembersListExport $export) : bool {
            $sheets = $export->sheets();

            $this->assertCount(2, $sheets['Committee members']->collection());
            $this->assertCount(1, $sheets['Active members']->collection());

            return true;
        });
    }
}
