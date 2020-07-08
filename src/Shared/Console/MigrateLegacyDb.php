<?php

declare(strict_types=1);

namespace Francken\Shared\Console;

use Illuminate\Console\Command;

class MigrateLegacyDb extends Command
{
    private const MIGRATION_FILES = [
        "2020_07_03_213354_create_activiteiten_legacy_table.php",
        "2020_07_03_213354_create_activiteit_lid_legacy_table.php",
        "2020_07_03_213354_create_afschrijvingen_legacy_table.php",
        "2020_07_03_213354_create_afschrijvingen_mail_legacy_table.php",
        "2020_07_03_213354_create_bedrijven_legacy_table.php",
        "2020_07_03_213354_create_bestellingen_legacy_table.php",
        "2020_07_03_213354_create_bestelling_product_legacy_table.php",
        "2020_07_03_213354_create_boeken_legacy_table.php",
        "2020_07_03_213354_create_boek_lid_legacy_table.php",
        "2020_07_03_213354_create_commissie_lid_legacy_table.php",
        "2020_07_03_213354_create_commissies_legacy_table.php",
        "2020_07_03_213354_create_leden_extras_legacy_table.php",
        "2020_07_03_213354_create_leden_legacy_table.php",
        "2020_07_03_213354_create_leveranciers_legacy_table.php",
        "2020_07_03_213354_create_producten_extras_legacy_table.php",
        "2020_07_03_213354_create_producten_legacy_table.php",
        "2020_07_03_213354_create_tbl_boeken_legacy_table.php",
        "2020_07_03_213354_create_tblsamenvattingen_legacy_table.php",
        "2020_07_03_213354_create_tbl_staff_legacy_table.php",
        "2020_07_03_213354_create_tbl_tentamens_legacy_table.php",
        "2020_07_03_213354_create_tbl_vakken_legacy_table.php",
        "2020_07_03_213354_create_tellingen_legacy_table.php",
        "2020_07_03_213354_create_telling_product_legacy_table.php",
        "2020_07_03_213354_create_transacties_legacy_table.php",
        "2020_07_03_213354_create_users_legacy_table.php",
        "2020_07_03_213354_create_vakgroepen_legacy_table.php",
        "2020_07_03_213354_create_zusterverenigingen_legacy_table.php",
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:legacy-db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Performs migrations on the legacy database';

    /**
     * Execute the console command.
     */
    public function handle() : void
    {
        $this->info("Calling migration fiels for legacy db");
        foreach (self::MIGRATION_FILES as $migration) {
            $this->call('migrate', [
                '--path' => "database/migrations/francken-legacy/{$migration}"
            ]);
        }
    }
}
