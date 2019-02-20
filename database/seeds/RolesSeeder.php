<?php

declare(strict_types=1);

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Make sure to import all permissions

        // this can be done as separate statements
        $role = Role::create(['name' => 'Admin']);
        $role->givePermissionTo(Permission::all());


        $role = Role::create(['name' => 'Board']);
        $role = Role::create(['name' => 'Old board']);
        $role = Role::create(['name' => 'Member']);
        $role = Role::create(['name' => 'Active Member']);
        $role = Role::create(['name' => 'Alumni member']);
    }
}
