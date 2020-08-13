<?php

declare(strict_types=1);

namespace Francken\Auth\Http\Controllers\Admin;

use Francken\Auth\Permission;
use Francken\Auth\Role;
use Illuminate\View\View;

final class RolesController
{
    public function index() : View
    {
        $roles = Role::with(['users', 'permissions'])
            ->paginate(30);

        return view('admin.compucie.roles.index', [
            'roles' => $roles,
            'breadcrumbs' => [
                ['url' => action([static::class, 'index']), 'text' => 'Roles'],
            ]
        ]);
    }

    public function show(Role $role) : View
    {
        $permissions = Permission::where('guard_name', 'web')->get();

        return view('admin.compucie.roles.show', [
            'role' => $role,
            'permissions' => $permissions,
            'breadcrumbs' => [
                ['url' => action([static::class, 'index']), 'text' => 'Roles'],
                ['url' => action([static::class, 'show'], $role->id), 'text' => $role->name],
            ]
        ]);
    }
}
