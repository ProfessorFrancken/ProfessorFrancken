<?php

declare(strict_types=1);

namespace Francken\Auth\Http\Controllers\Admin;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

final class RolesController
{
    public function index()
    {
        $roles = Role::with(['users', 'permissions'])
            ->paginate(30);

        return view('admin.compucie.roles.index', [
            'roles' => $roles,
        ]);
    }

    public function show(Role $role)
    {
        $roles = Role::where('guard_name', 'web')->get();
        $permissions = Permission::where('guard_name', 'web')->get();

        return view('admin.compucie.roles.show', [
            'role' => $role,
            'permissions' => $permissions,
        ]);
    }
}
