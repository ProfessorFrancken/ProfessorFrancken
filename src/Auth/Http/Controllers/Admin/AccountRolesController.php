<?php

declare(strict_types=1);

namespace Francken\Auth\Http\Controllers\Admin;

use Francken\Auth\Account;
use Spatie\Permission\Models\Role;

final class AccountRolesController
{
    public function store(Account $account, Role $role)
    {
        $account->assignRole($role);
        return redirect()->back();
    }

    public function remove(Account $account, Role $role)
    {
        $account->removeRole($role);
        return redirect()->back();
    }
}
