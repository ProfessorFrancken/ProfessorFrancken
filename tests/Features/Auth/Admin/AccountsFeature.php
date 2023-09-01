<?php

declare(strict_types=1);

namespace Francken\Features\Auth\Admin;

use Francken\Association\LegacyMember;
use Francken\Auth\Http\Controllers\Admin\AccountsController;
use Francken\Features\LoggedInAsAdmin;
use Francken\Features\TestCase;

class AccountsFeature extends TestCase
{
    use LoggedInAsAdmin;

    /** @test */
    public function it_allows_to_gives_a_roles_to_an_account() : void
    {
        $member = factory(LegacyMember::class)->create(['is_lid' => true]);

        $this->visit(action([AccountsController::class, 'index']))
            ->click('Activate a new account')
            ->seePageIs(action(
                [AccountsController::class, 'create'],
            ))
             ->type($member->id, 'member_id')
            ->press('Activate')
            ->seePageIs(action(
                [AccountsController::class, 'index'],
            ))
            ->see($member->emailadres);
    }
}
