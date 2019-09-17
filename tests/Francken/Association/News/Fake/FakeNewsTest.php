<?php

declare(strict_types=1);

namespace Francken\Tests\Association\News\Fake;

use Faker\Factory;
use Francken\Association\News\Fake\FakeNews;
use Francken\Association\News\NewsItem;
use PHPUnit\Framework\TestCase as TestCase;

final class FakeNewsTest extends TestCase
{
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
        $this->assertNull($news[4]->previousNewsItem());

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

        $this->assertNull($news[0]->nextNewsItem());
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

        $publishedAt = $news[0]->publicationDate();

        foreach (array_slice($news, 1) as $item) {
            $publishedAtNow = $item->publicationDate();
            $this->assertTrue(
                $publishedAt > $publishedAtNow
            );
            $publishedAt = $publishedAtNow;
        }
    }

    private function assertPreviousNewsItemIsEqualTo(NewsItem $item, NewsItem $previous) : void
    {
        $this->assertEquals(
            $item->previousNewsItem()->url(),
            $previous->url()
        );

        $this->assertEquals(
            $item->previousNewsItem()->title(),
            $previous->title()
        );

        $this->assertTrue(
            $previous->publicationDate() <= $item->publicationDate(),
            "The previous news item should be published before the current one"
        );
    }

    private function assertNextNewsItemIsEqualTo(NewsItem $item, NewsItem $next) : void
    {
        $this->assertEquals(
            $item->nextNewsItem()->url(),
            $next->url()
        );

        $this->assertEquals(
            $item->nextNewsItem()->title(),
            $next->title()
        );

        $this->assertTrue(
            $next->publicationDate() >= $item->publicationDate(),
            "The previous news item should be published before the current one"
        );
    }
}
