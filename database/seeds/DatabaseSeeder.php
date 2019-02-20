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

        DB::table('users')->insert([
            'id' => '1',
            'email' => 'markredeman@gmail.com',
            'francken_id' => 1403,
            'password' => bcrypt($passphrase),
            'can_access_admin' => true
        ]);

        $this->call(CommitteesSeeder::class);
        $this->call(RolesSeeder::class);


        $this->call(PostsSeeder::class);
        $this->call(RegistrationRequestsSeeder::class);
        $this->call(BooksSeeder::class);
        $this->call(FranckenVrijSeeder::class);

        $mark = Account::create([
            'email' => 'markredeman@gmail.com',
            'member_id' => 1403,
            'password' => bcrypt($passphrase),
        ]);
        $mark->assignrole('Admin');
    }
}
