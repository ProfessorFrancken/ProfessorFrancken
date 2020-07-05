<?php

declare(strict_types=1);

namespace Francken\Auth;

use Illuminate\Console\Command;
use Illuminate\Contracts\Config\Repository;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Check whether there are new permissions in our configuration and add these
 */
final class ImportPermissionsFromConfig extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import missing permissions from the permissions configuration files';

    private Repository $config;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Repository $config)
    {
        parent::__construct();
        $this->config = $config;
    }

    /**
     * Execute the console command.
     */
    public function handle() : void
    {
        $permissionsPerGuard = $this->config->get('francken.permissions');

        $admin = Role::where('name', 'Admin')->first();

        foreach ($permissionsPerGuard as $guard => $permissions) {
            $this->info("Importing permissions for the {$guard} guard");
            foreach ($permissions as $permission) {
                if ( ! Permission::where('guard_name', $guard)->where('name', $permission)->exists()) {
                    $permission = Permission::create([
                        'guard_name' => $guard,
                        'name' => $permission
                    ]);

                    if ($guard === $admin->guard_name) {
                        $admin->givePermissionTo($permission);
                    }
                }
            }
        }

        $this->info("Importing completed");
    }
}
