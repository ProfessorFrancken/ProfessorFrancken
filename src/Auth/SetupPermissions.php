<?php


declare(strict_types=1);

namespace Francken\Auth;

use Illuminate\Console\Command;
use Spatie\Permission\PermissionRegistrar;

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
        $this->seedRolesAndPermissions();
    }

    private function seedRolesAndPermissions() : void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Make sure to import all permissions
        Role::create(['name' => Role::ADMIN]);
        $this->call('permission:import');

        Role::create(['name' => ChangeRolesListener::BOARD_ROLE]);
        Role::create(['name' => ChangeRolesListener::CANDIDATE_BOARD_ROLE]);
        Role::create(['name' => ChangeRolesListener::DEMISSIONED_BOARD_ROLE]);
        Role::create(['name' => ChangeRolesListener::DECHARGED_BOARD_ROLE]);

        Role::create(['name' => 'Member']);
        Role::create(['name' => 'Active Member']);
        Role::create(['name' => 'Alumni member']);
    }
}
