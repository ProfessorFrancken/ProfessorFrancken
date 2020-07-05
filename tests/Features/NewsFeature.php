<?php

declare(strict_types=1);

namespace Francken\Features;

use Faker\Factory;
use Francken\Association\News\Fake\FakeNews;
use Francken\Association\News\Http\NewsController;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class NewsFeature extends TestCase
{
    use DatabaseMigrations;

    /** @before */
    public function setupNews() : void
    {
        $this->afterApplicationCreated(function () : void {
            $faker = Factory::create();
            $faker->seed(31415);

            $fakeNews = new FakeNews($faker, 10);
            $news = $fakeNews->all();

            foreach ($news as $newsItem) {
                $newsItem->save();
            }
        });
    }

    /** @test */
    public function the_latest_news_is_shown() : void
    {
        $this->visit(
            action([NewsController::class, 'index'])
        )
            ->click('Read more')

            // Check that we now are on a news item page
            // which contains info about its author
            ->see('Written by');

        $this->assertResponseOk();
    }

    /** @test */
    public function the_archive_can_be_used_to_search_for_old_news() : void
    {
        $this->visit(
            action([NewsController::class, 'archive'])
        );

        $this->assertResponseOk();
    }
}
