<?php

declare(strict_types=1);

use Francken\Auth\Account;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        $passphrase = config('francken.general.admin_passphrase');

        $this->call(CommitteesSeeder::class);
        $this->call(RolesSeeder::class);

        $this->call(BooksSeeder::class);
        $this->call(FranckenVrijSeeder::class);

        $mark = Account::create([
            'email' => 'markredeman@gmail.com',
            'member_id' => 1403,
            'password' => bcrypt($passphrase),
        ]);
        $mark->assignrole('Admin');

        $this->call(LustrumSeeder::class);
    }
}
