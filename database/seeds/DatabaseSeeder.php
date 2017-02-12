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
        DB::table('users')->insert(['id' => '1']);

        $this->call(CommitteesSeeder::class);
        $this->call(PostsSeeder::class);
        $this->call(RegistrationRequestsSeeder::class);
        $this->call(BooksSeeder::class);
        $this->call(FranckenVrijSeeder::class);
    }
}
