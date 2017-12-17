<?php

declare(strict_types=1);

namespace Francken\Association\News\Cache;

use DateTimeImmutable;
use Faker\Generator;
use Francken\Association\News\Author;
use Francken\Association\News\Repository as NewsRepository;
use Francken\Association\News\NewsItem;
use Francken\Association\News\NewsItemLink;
use Francken\Domain\News\AuthorId;
use Francken\Domain\News\NewsId;
use Illuminate\Cache\Repository as CacheRepository;
use League\Period\Period;

final class Repository implements NewsRepository

{
    const REMEMBER_TIME = 60 * 60 * 24;

    private $cache;
    private $news;

    public function __construct(NewsRepository $news, CacheRepository $cache)
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

    public function search(Period $period = null, string $subject = null, string $author = null) : array
    {
        return $this->news->search($period, $subject, $author);
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
