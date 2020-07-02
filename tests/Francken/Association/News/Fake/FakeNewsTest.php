<?php

declare(strict_types=1);

namespace Francken\Tests\Association\News\Fake;

use Faker\Factory;
use Francken\Association\News\Eloquent\News;
use Francken\Association\News\Fake\FakeNews;
use Francken\Features\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

final class FakeNewsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_generates_fake_news_items() : void
    {
        $fakeNews = new FakeNews(Factory::create(), 100);

        $this->assertCount(100, $fakeNews->all());
    }

    /** @test */
    public function it_keeps_track_of_previous_news_items() : void
    {
        $fakeNews = new FakeNews(Factory::create(), 5);

        $news = $fakeNews->all();

        // The last news item can't have a previous news item
        $this->assertPreviousNewsItemIsEqualTo($news[3], $news[4]);
        $this->assertPreviousNewsItemIsEqualTo($news[2], $news[3]);
        $this->assertPreviousNewsItemIsEqualTo($news[1], $news[2]);
        $this->assertPreviousNewsItemIsEqualTo($news[0], $news[1]);
    }

    /** @test */
    public function it_keeps_track_of_next_news_items() : void
    {
        $fakeNews = new FakeNews(Factory::create(), 5);

        $news = $fakeNews->all();

        $this->assertNextNewsItemIsEqualTo($news[1], $news[0]);
        $this->assertNextNewsItemIsEqualTo($news[2], $news[1]);
        $this->assertNextNewsItemIsEqualTo($news[3], $news[2]);
        $this->assertNextNewsItemIsEqualTo($news[4], $news[3]);

        // The most recent news item can't have a next news item
    }

    /** @test */
    public function it_orders_all_news_items_based_on_publication_date() : void
    {
        $fakeNews = new FakeNews(Factory::create(), 10);

        $news = $fakeNews->all();

        $publishedAt = $news[0]->published_at;

        foreach ($news->slice(1) as $item) {
            $publishedAtNow = $item->published_at;
            $this->assertTrue(
                $publishedAt > $publishedAtNow
            );
            $publishedAt = $publishedAtNow;
        }
    }

    private function assertPreviousNewsItemIsEqualTo(News $item, News $previous) : void
    {
        $this->assertTrue(
            $previous->published_at <= $item->published_at,
            "The previous news item should be published before the current one"
        );
    }

    private function assertNextNewsItemIsEqualTo(News $item, News $next) : void
    {
        $this->assertTrue(
            $next->published_at >= $item->published_at,
            "The previous news item should be published before the current one"
        );
    }
}
