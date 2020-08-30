<?php

declare(strict_types=1);

namespace Francken\Features\Admin;

use Francken\Association\Boards\Board;
use Francken\Association\Boards\BoardMember;
use Francken\Auth\Account;
use Francken\Features\LoggedInAsAdmin;
use Francken\Features\TestCase;
use Francken\Shared\Http\Controllers\BoardDashboardController;
use Francken\Shared\Http\Controllers\DashboardController;
use Francken\Shared\Http\Controllers\MemberDashboardController;

class DashboardFeature extends TestCase
{
    use LoggedInAsAdmin;

    /** @test */
    public function it_redirects_to_the_members_dashboard_controller() : void
    {
        $board = factory(Board::class)->create([
            'installed_at' => '2020-06-06'
        ]);
        $boardMember = factory(BoardMember::class)->create([
            'board_id' => $board->id
        ]);

        $this->visit(action([DashboardController::class, 'redirectToDashboard']))
             ->seePageIs(action(
                 [MemberDashboardController::class, 'index']
             ));
    }

    /** @test */
    public function it_redirects_to_the_board_dashboard_controller() : void
    {
        $account = factory(Account::class)->create([]);
        $account->givePermissionTo('can-access-dashboard');

        auth()->login($account);

        $board = factory(Board::class)->create([
            'installed_at' => '2020-06-06'
        ]);
        factory(BoardMember::class)->create([
            'board_id' => $board->id,
            'member_id' => $account->member_id
        ]);

        $this->visit(action([DashboardController::class, 'redirectToDashboard']))
             ->seePageIs(action(
                 [BoardDashboardController::class, 'index']
             ));
    }
}
