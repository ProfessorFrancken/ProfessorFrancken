<?php

declare(strict_types=1);

namespace Francken\Tests\Infrastructure\News;

use DateTimeImmutable;
use Francken\Application\News\Author;
use Francken\Application\News\NewsItem;
use Francken\Application\News\NewsRepository;
use Francken\Application\News\CompiledMarkdown;
use Francken\Infrastructure\News\CachedNewsRepository;
use Illuminate\Cache\Repository;
use League\Period\Period;
use PHPUnit_Framework_TestCase as TestCase;
use Prophecy\Argument;

class CachedNewsRepositoryTest extends TestCase
{
    /** @test */
    function it_caches_the_in_period_method()
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
    function it_caches_the_by_link_method()
    {
        $cache = $this->prophesize(Repository::class);
        $news = $this->prophesize(NewsRepository::class);

        $cachedNews = new CachedNewsRepository(
            $news->reveal(), $cache->reveal()
        );

        // Check that the cache key was set correctly, we
        // will assume that the timespan
        $item = new NewsItem(
            'title', 'exerpt', new \DateTimeImmutable('2017-07-13'), new Author('Mark', ''), new CompiledMarkdown('')
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
    function it_caches_the_recent_method()
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
