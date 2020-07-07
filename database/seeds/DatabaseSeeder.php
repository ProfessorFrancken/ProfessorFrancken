<?php

declare(strict_types=1);

use Francken\Auth\Account;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public const MEMBER_ID = 1403;

    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        $passphrase = config('francken.general.admin_passphrase');

        $this->call(LegacySeeder::class);
        $this->call(AuthSeeder::class);
        $this->call(BoardsSeeder::class);
        $this->call(ActivitiesSeeder::class);
        $this->call(FranckenVrijSeeder::class);

        $mark = Account::create([
            'email' => 'markredeman@gmail.com',
            'member_id' => self::MEMBER_ID,
            'password' => bcrypt($passphrase),
        ]);
        $mark->assignrole('Admin');

        $this->call(LustrumSeeder::class);
    }
}
