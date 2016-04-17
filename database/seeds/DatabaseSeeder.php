<?php

use Illuminate\Database\Seeder;

use App\ReadModel\PostList\PostList;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	for ($i=0; $i < 50; $i++) { 
	        DB::table('posts')->insert([
	            'title' => str_random(20),
	            'content' => str_random(100)
	        ]);
    	}
        //$this->call(PostsTableSeeder::class);
    }
}
