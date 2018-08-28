<?php

use Francken\Domain\Posts\PostId;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $passphrase = config('francken.general.admin_passphrase');

        DB::table('users')->insert([
            'id' => '1',
            'francken_id' => 1403,
            'email' => 'markredeman@gmail.com',
            'password' => bcrypt($passphrase),
            'can_access_admin' => true
        ]);

        $this->call(CommitteesSeeder::class);
        $this->call(PostsSeeder::class);
        $this->call(RegistrationRequestsSeeder::class);
        $this->call(BooksSeeder::class);
        $this->call(FranckenVrijSeeder::class);
    }
}
