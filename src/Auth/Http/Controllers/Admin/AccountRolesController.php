<?php

declare(strict_types=1);

namespace Francken\Auth\Http\Controllers\Admin;

use Francken\Auth\Account;
use Francken\Auth\Role;
use Illuminate\Http\RedirectResponse;

final class AccountRolesController
{
    public function store(Account $account, Role $role) : RedirectResponse
    {
        $account->assignRole($role);
        return redirect()->back();
    }

    public function remove(Account $account, Role $role) : RedirectResponse
    {
        $account->removeRole($role);
        return redirect()->back();
    }
}
