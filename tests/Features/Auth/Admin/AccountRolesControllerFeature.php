<?php

declare(strict_types=1);

namespace Francken\Features\Auth\Admin;

use Francken\Auth\Account;
use Francken\Auth\Http\Controllers\Admin\AccountRolesController;
use Francken\Auth\Http\Controllers\Admin\AccountsController;
use Francken\Auth\Role;
use Francken\Features\LoggedInAsAdmin;
use Francken\Features\TestCase;

class AccountRolesControllerFeature extends TestCase
{
    use LoggedInAsAdmin;

    /** @test */
    public function it_allows_to_givs_a_roles_to_an_account() : void
    {
        $account = factory(Account::class)->create();
        $role = Role::firstOrCreate(['name' => 'custom role']);

        $this->visit(action(
            [AccountsController::class, 'show'], ['account' => $account]
        ))
            ->see('custom role')
            ->post(action(
                [AccountRolesController::class, 'store'],
                [$account->id, $role->id]
            ))
            ->assertRedirectedTo(action(
                [AccountsController::class, 'show'],
                ['account' => $account]
            ))
            ->followRedirects()
            ->seePageIs(action(
                [AccountsController::class, 'show'],
                ['account' => $account]
            ));

        $this->assertTrue($account->hasRole('custom role'));

        $this->press('Remove')
             ->seePageIs(action(
                 [AccountsController::class, 'show'], ['account' => $account]
             ));

        $account->refresh();
        $this->assertFalse($account->hasRole('custom role'));
    }
}
