<?php

declare(strict_types=1);

namespace Francken\Features\Association\Boards;

use DateTimeImmutable;
use Francken\Association\Boards\BoardMember;
use Francken\Association\Boards\BoardMemberStatus;
use Francken\Association\Boards\Http\Controllers\KandiTotoController;
use Francken\Association\Boards\KandiToto\Bet;
use Francken\Auth\Account;
use Francken\Auth\ChangeRolesListener;
use Francken\Features\LoggedInAsAdmin;
use Francken\Features\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TotoFeature extends TestCase
{
    use LoggedInAsAdmin;
    use DatabaseTransactions;

    /** @test */
    public function a_list_of_boards_is_shown() : void
    {
        $account = Account::first();
        BoardMember::create([
            'board_id' => 0,
            'member_id' => $account->member_id,
            'name' => 'Mark',
            'title' => 'Mark',

            'board_member_status' => BoardMemberStatus::DEMISSIONED_BOARD_MEMBER,
            'installed_at' => new DateTimeImmutable(),
        ]);
        $account->assignRole(ChangeRolesListener::DEMISSIONED_BOARD_ROLE);

        $this->visit(action([KandiTotoController::class, 'index']))
            ->see('Kandi Toto')
             ->type('Kathinka', 'president')
             ->type('Anna', 'secretary')
             ->type('Arjen', 'treasurer')
             ->type('Su', 'intern')
             ->type('Mark', 'extern')
             ->type('Hoi', 'wildcard')
             ->press('Submit');

        $bet = Bet::where('member_id', $account->member_id)->firstOrFail();
        $this->assertEquals('Kathinka', $bet->president);
        $this->assertEquals('Anna', $bet->secretary);
        $this->assertEquals('Arjen', $bet->treasurer);
        $this->assertEquals('Su', $bet->intern);
        $this->assertEquals('Mark', $bet->extern);
        $this->assertEquals('Hoi', $bet->wildcard);

        $this->see('Kathinka')
            ->see('Anna')
            ->see('Arjen')
            ->see('Su')
            ->see('Mark')
            ->see('HOi');
    }
}
