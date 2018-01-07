<?php

declare(strict_types=1);

namespace Francken\Tests\Association\News\Eloquent;

use Francken\Association\News\Eloquent\News;
use Francken\Association\News\NewsItem;
use Francken\Association\News\Fake\FakeNews;
use Faker\Factory;
use Francken\Features\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

final class NewsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function it_can_be_converted_from_and_to_a_news_item()
    {
        $faker = Factory::create();
        $faker->seed(31415);
        $fakeNews = (new FakeNews($faker, 30))->all();

        foreach ($fakeNews as $news) {
            $eloquent = News::fromNewsItem($news);
            $eloquent->save();
        }

        foreach ($fakeNews as $news) {
            $eloquent = News::withSubject($news->title())->first();

            $this->assertEquals(
                $news,
                $eloquent->toNewsItem()
            );
        }
    }
}
