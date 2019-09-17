<?php

declare(strict_types=1);

namespace Francken\Tests\Association\News\Cache;

use DateTimeImmutable;
use Francken\Association\News\Author;
use Francken\Association\News\Cache\Repository as CachedNewsRepository;
use Francken\Association\News\CompiledMarkdown;
use Francken\Association\News\NewsItem;
use Francken\Association\News\Repository as NewsRepository;
use Illuminate\Cache\Repository;
use League\Period\Period;
use PHPUnit\Framework\TestCase as TestCase;
use Prophecy\Argument;

class RepositoryTest extends TestCase
{
    /** @test */
    public function it_caches_the_in_period_method() : void
    {
        $cache = $this->prophesize(Repository::class);
        $news = $this->prophesize(NewsRepository::class);

        $cachedNews = new CachedNewsRepository(
            $news->reveal(), $cache->reveal()
        );

        // Check that the cache key was set correctly, we
        // will assume that the timespan
        $cache->remember(
            'news_period_17-04-26_17-04-27',
            Argument::type('int'),
            Argument::any()
        )->willReturn(['news']);


        $period = new Period(
            new DateTimeImmutable('2017-04-26'),
            new DateTimeImmutable('2017-04-27')
        );
        $result = $cachedNews->inPeriod($period);


        $this->assertEquals(['news'], $result);
    }

    /** @test */
    public function it_caches_the_by_link_method() : void
    {
        $cache = $this->prophesize(Repository::class);
        $news = $this->prophesize(NewsRepository::class);

        $cachedNews = new CachedNewsRepository(
            $news->reveal(), $cache->reveal()
        );

        // Check that the cache key was set correctly, we
        // will assume that the timespan
        $item = new NewsItem(
            'title', 'exerpt', new Author('Mark', ''), new CompiledMarkdown(''), new \DateTimeImmutable('2017-07-13')
        );
        $cache->remember(
            'news_link_asdf',
            Argument::type('int'),
            Argument::any()
        )->willReturn($item);


        $result = $cachedNews->byLink('asdf');

        $this->assertEquals($item, $result);
    }

    /** @test */
    public function it_caches_the_recent_method() : void
    {
        $cache = $this->prophesize(Repository::class);
        $news = $this->prophesize(NewsRepository::class);

        $cachedNews = new CachedNewsRepository(
            $news->reveal(), $cache->reveal()
        );

        // Check that the cache key was set correctly, we
        // will assume that the timespan
        $cache->remember(
            'news_recent_12',
            Argument::type('int'),
            Argument::any()
        )->willReturn(['news']);


        $result = $cachedNews->recent(12);

        $this->assertEquals(['news'], $result);
    }
}
