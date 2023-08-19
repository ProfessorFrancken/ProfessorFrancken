<?php

declare(strict_types=1);

namespace Francken\Features\Association\Boards;

use Francken\Association\Boards\Board;
use Francken\Association\Boards\BoardMemberWasDemissioned;
use Francken\Association\Boards\BoardMemberWasDischarged;
use Francken\Association\Boards\BoardMemberWasInstalled;
use Francken\Association\Boards\BoardWasInstalled;
use Francken\Association\Boards\Http\Controllers\AdminBoardsController;
use Francken\Association\Boards\MemberBecameCandidateBoardMember;
use Francken\Features\LoggedInAsAdmin;
use Francken\Features\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;

class AdminBoardsFeature extends TestCase
{
    use LoggedInAsAdmin;
    use DatabaseTransactions;

    /** @test */
    public function a_list_of_boards_is_shown() : void
    {
        $this->visit(action([AdminBoardsController::class, 'index']))
            ->see('Import');

        $this->assertResponseOk();
    }

    /** @test */
    public function a_board_can_be_installed() : void
    {
        Event::fake();
        $this->visit(action([AdminBoardsController::class, 'create']));

        $this->assertResponseOk();
        $this->type('Hè Watt?', 'name')
            ->type('2017-06-06', 'installed_at')
            ->attach(UploadedFile::fake()->image('board.png'), 'photo')
            ->type('1037', 'members[0][member_id]')
            ->type('President', 'members[0][title]')
            ->attach(UploadedFile::fake()->image('president.png'), 'members[0][photo]')
            ->type('1403', 'members[1][member_id]')
            ->type('Commisioner of external relations', 'members[1][title]')
            ->type('1608', 'members[2][member_id]')
            ->type('Commisioner of internal relations', 'members[2][title]')
            ->press('Install')
            ->see('Hè Watt?');

        //
        Event::assertDispatched(BoardMemberWasInstalled::class, 3);
        Event::assertDispatched(BoardWasInstalled::class);

        // Next we should be able to edit the same board
        $board = Board::where('name', 'Hè Watt?')->firstOrFail();
        $this->visit(action([AdminBoardsController::class, 'edit'], $board->id))
            ->type('Hè Watt?!', 'name')
            ->type('2018-06-06', 'demissioned_at')
            ->type('2018-09-06', 'decharged_at')
            // Check if decharged board members work
            ->type('2018-06-06', 'members[0][demissioned_at]')
            ->type('2018-09-06', 'members[0][decharged_at]')
            // Check if demissioned board members work
            ->type('1608', 'members[2][member_id]')
            ->type('Commisioner of internal relations', 'members[2][title]')
            ->type('2017-06-06', 'members[2][installed_at]')
            ->type('2018-06-06', 'members[2][demissioned_at]')
            // Check if cnadidate board members work
            ->type('1333', 'members[3][member_id]')
            ->type('Treasurer', 'members[3][title]')
            ->type('2030-06-06', 'members[3][installed_at]')
            ->press('Save');

        Event::assertDispatched(BoardMemberWasDischarged::class);
        Event::assertDispatched(BoardMemberWasDemissioned::class);
        Event::assertDispatched(MemberBecameCandidateBoardMember::class);
    }

    // Fixing Laravel bugs

    /**
     * Store an array based file upload with the proper nested array structure.
     *
     * @param  array  $uploads
     * @param  string  $key
     * @param mixed $file
     */
    protected function prepareArrayBasedFileInput(&$uploads, $key, $file) : void
    {
        preg_match_all('/([^\[\]]+)/', $key, $segments);

        $segments = array_reverse($segments[1]);

        $newKey = array_pop($segments);

        foreach ($segments as $segment) {
            $file = [$segment => $file];
        }

        $uploads[$newKey] = isset($uploads[$newKey]) ? array_merge(
            $uploads[$newKey],
            $file
        ) : $file;

        unset($uploads[$key]);
    }
}
