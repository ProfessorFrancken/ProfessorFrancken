<?php

declare(strict_types=1);

namespace Francken\Features;

use Francken\Association\News\Repository as NewsRepository;
use Francken\Association\News\Fake\FakeNews;
use Francken\Association\News\InMemory\Repository as InMemoryNewsRepository;
use Faker\Factory;

class NewsFeature extends TestCase
{
    private $news;

    // inmemory with fakes

    /** @before */
    function setupNews()
    {
        $this->afterApplicationCreated(function () {
            $faker = Factory::create();
            $faker->seed(31415);
            $fakeNews = new FakeNews($faker, 10);

            $this->news = new InMemoryNewsRepository($fakeNews->all());

            \App::instance(NewsRepository::class, $this->news);
        });
    }

    /** @test */
    function the_latest_news_is_shown()
    {
        $this->visit('/association/news')
            ->click('Read more')

            // Check that we now are on a news item page
            // which contains info about its author
            ->see('Written by');

        $this->assertResponseOk();
    }

    /** @test */
    function the_archive_can_be_used_to_search_for_old_news()
    {
        $this->visit('/association/news/archive');

        $this->assertResponseOk();
    }
}
