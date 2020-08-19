<?php

declare(strict_types=1);

namespace Francken\Features\Auth\Admin;

use Francken\Auth\Account;
use Francken\Auth\Http\Controllers\Admin\AccountsController;
use Francken\Auth\Permission;
use Francken\Features\LoggedInAsAdmin;
use Francken\Features\TestCase;

class AccountPermissionControllerFeature extends TestCase
{
    use LoggedInAsAdmin;

    /** @test */
    public function it_allows_to_givs_a_permission_to_an_account() : void
    {
        $account = factory(Account::class)->create();
        $permission = Permission::firstOrCreate(['name' => 'custom permission']);

        $this->visit(action(
            [AccountsController::class, 'show'], ['account' => $account]
        ))
             ->select($permission->id, 'permission_id')
             ->within(
                 '#permission-form',
                 fn () => $this->press('Add')
             )
             ->seePageIs(action(
            [AccountsController::class, 'show'], ['account' => $account]
        ));

        $this->assertTrue($account->hasPermissionTo('custom permission'));

        $this->press('Remove')
             ->seePageIs(action(
                 [AccountsController::class, 'show'], ['account' => $account]
             ));

        $account->refresh();
        $this->assertFalse($account->hasPermissionTo('custom permission'));
    }
}
