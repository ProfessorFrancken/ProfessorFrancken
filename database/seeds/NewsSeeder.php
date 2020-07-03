<?php

declare(strict_types=1);

use Faker\Factory;
use Francken\Association\News\Fake\FakeNews;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        $faker = Factory::create();
        $faker->seed(31415);
        $fakeNews = (new FakeNews($faker, 30))->all();

        foreach ($fakeNews as $news) {
            $news->save();
        }
    }
}
