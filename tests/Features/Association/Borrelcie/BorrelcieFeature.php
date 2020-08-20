<?php

declare(strict_types=1);

namespace Francken\Features\Association\Borrelcie;

use Francken\Association\Borrelcie\Http\BorrelcieAccountActivationController;
use Francken\Association\Borrelcie\Http\BorrelcieController;
use Francken\Auth\Account;
use Francken\Features\TestCase;

class BorrelcieFeature extends TestCase
{
    /** @test */
    public function it_allows_a_member_to_activate_their_borrelcie_account() : void
    {
        $account = factory(Account::class)->create();
        $this
            ->actingAs($account)
            ->visit(action([BorrelcieController::class, 'index']))
            ->followRedirects()
            ->seePageIs(action([BorrelcieAccountActivationController::class, 'index']))
            ->press('Activate your account')
            ->seePageIs(action([BorrelcieController::class, 'index']));
    }
}
