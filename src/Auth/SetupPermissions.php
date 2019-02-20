<?php


declare(strict_types=1);

namespace Francken\Auth;

use DB;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Used
 */
final class SetupPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate the old users table to new accounts table and add permissions / roles';

    /**
     * Execute the console command.
     */
    public function handle() : void
    {
        $this->seedRoles();
        $old_users = DB::table('users')->get();

        foreach ($old_users as $user) {
            $account = Account::create([
                'email' => $user->email,
                'password' => $user->password,
                'member_id' => $user->francken_id,
            ]);

            if ($user->can_access_admin) {
                $account->assignrole('Board');
            }
        }
    }

    private function seedRoles() : void
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
