<?php

declare(strict_types=1);

namespace Francken\Infrastructure\News;

use DateTimeImmutable;
use Faker\Generator;
use Francken\Application\News\Author;
use Francken\Application\News\NewsRepository;
use Francken\Application\News\NewsItem;
use Francken\Application\News\NewsItemLink;
use Francken\Application\News\NewsItemPreview;
use Francken\Domain\News\AuthorId;
use Francken\Domain\News\NewsId;
use Illuminate\Cache\Repository;
use League\Period\Period;

final class CachedNewsRepository implements NewsRepository

{
    const REMEMBER_TIME = 60 * 60 * 24;

    private $cache;
    private $news;

    public function __construct(NewsRepository $news, Repository $cache)
    {
        $this->cache = $cache;
        $this->news = $news;
    }

    public function inPeriod(Period $period) : array
    {
        return $this->cache->remember(
            $this->periodCacheKey($period),
            self::REMEMBER_TIME,
            function() use ($period) {
                return $this->news->inPeriod($period);
            }
        );
    }

    public function byLink(string $link) : NewsItem
    {
        return $this->cache->remember(
            $this->linkCacheKey($link),
            self::REMEMBER_TIME,
            function() use ($link) {
                return $this->news->byLink($link);
            }
        );
    }

    public function recent(int $amount) : array
    {
        return $this->cache->remember(
            $this->recentCacheKey($amount),
            self::REMEMBER_TIME,
            function() use ($amount) {
                return $this->news->recent($amount);
            }
        );
    }

    private function periodCacheKey(Period $period) : string
    {
        return sprintf(
            'news_period_%s_%s',
            $period->getStartDate()->format('y-m-d'),
            $period->getEndDate()->format('y-m-d')
        );
    }

    private function linkCacheKey(string $link) : string
    {
        return sprintf('news_link_%s', $link);
    }

    private function recentCacheKey(int $amount) : string
    {
        return sprintf('news_recent_%d', $amount);
    }
}
