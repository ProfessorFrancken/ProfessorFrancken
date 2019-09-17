<?php

declare(strict_types=1);

namespace Francken\Infrastructure\Console;

use Artisan;
use DB;
use Illuminate\Console\Command;

final class MigrateSqliteToMysql extends Command
{
    private const FRANCKEN_2_CONNECTION = 'francken_2';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Move data';

    /**
     * Execute the console command.
     */
    public function handle() : void
    {
        if ( ! $this->confirm('Are you sure you want to migrate from sqlite to mysql?')) {
            return;
        }

        config(['telescope.storage.database.connection' => self::FRANCKEN_2_CONNECTION]);
        Artisan::call('migrate:fresh', [
            '--database' => self::FRANCKEN_2_CONNECTION,
            '--force' => true,
            '--step' => true,
        ]);

        if ( ! $this->confirm('Do you wish to continue?')) {
            return;
        }

        $tables = [
            "activities",
            "albums",
            "all_books",
            "association_board_members",
            "association_boards",
            "association_symposia",
            "association_symposium_ad_counts",
            "association_symposium_participants",
            "auth_accounts",
            "auth_model_has_permissions",
            "auth_model_has_roles",
            "auth_password_resets",
            "auth_permissions",
            "auth_role_has_permissions",
            "auth_roles",
            "available_books",
            "committees_list",
            "event_store",
            // "failed_jobs",
            "francken_vrij",
            "jas_events",
            "media",
            "mediables",
            "members",
            "news",
            "notifications",
            "photos",
            "posts",
            "request_status",
            // "telescope_entries",
            // "telescope_entries_tags",
            // "telescope_monitoring",
            "treasurer_deduction_email_to_members",
            "treasurer_deduction_emails",
            "treasurer_transaction_notes",
            "users",
        ];


        $bar = $this->output->createProgressBar(count($tables));
        $bar->start();

        $francken_2 = DB::connection(self::FRANCKEN_2_CONNECTION);
        DB::connection(self::FRANCKEN_2_CONNECTION)->statement('SET FOREIGN_KEY_CHECKS=0;');

        foreach ($tables as $table) {
            $this->info("Migrating data from [{$table}] table");
            $this->migrateTable($table);
            $bar->advance();
        }
        $bar->finish();

        DB::connection(self::FRANCKEN_2_CONNECTION)->statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    private function migrateTable(string $table) : void
    {
        $francken_2 = DB::connection(self::FRANCKEN_2_CONNECTION);
        $francken_2->table($table)->truncate();

        $rows = DB::connection(config('database.default'))->table($table)->get();
        $this->info("Inserting {$rows->count()} rows");
        $rows->chunk(500)
            ->each(function ($rows) use ($francken_2, $table) : void {
                $francken_2->table($table)
                    ->insert(
                        $rows->map(function ($row) {
                            return (array)$row;
                        })
                        ->toArray()
                    );
            });
    }
}
