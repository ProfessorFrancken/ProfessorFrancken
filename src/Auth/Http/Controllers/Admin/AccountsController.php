<?php

declare(strict_types=1);

namespace Francken\Auth\Http\Controllers\Admin;

use Francken\Auth\Account;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

final class AccountsController
{
    public function index()
    {
        $accounts = Account::with(['roles', 'permissions'])
            ->paginate(30);

        return view('admin.compucie.accounts.index', [
            'accounts' => $accounts,
        ]);
    }

    public function show(Account $account)
    {
        $roles = Role::where('guard_name', 'web')->get();
        $permissions = Permission::where('guard_name', 'web')->get();

        return view('admin.compucie.accounts.show', [
            'account' => $account,
            'permissions' => $permissions,
            'roles' => $roles,
        ]);
    }
}
