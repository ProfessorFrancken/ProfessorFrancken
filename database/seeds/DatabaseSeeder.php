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
        for ($i = 0; $i < 50; $i++) {
            DB::table('posts')->insert([
                'id' => PostId::generate(),
                'title' => str_random(20),
                'content' => str_random(100)
            ]);
        }

        $this->call(CommitteesSeeder::class);
        $this->call(PostsSeeder::class);
        $this->call(RegistrationRequestsSeeder::class);
        $this->call(BooksSeeder::class);
        $this->call(FranckenVrijSeeder::class);
    }
}
