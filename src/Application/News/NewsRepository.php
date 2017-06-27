<?php

declare(strict_types=1);

namespace Francken\Application\News;

use Francken\Domain\News\NewsId;
use Francken\Domain\News\AuthorId;
use Faker\Generator;
use League\Period\Period;
use DateTimeImmutable;
use Francken\Infrastructure\News\FakeNewsRepository;
use Francken\Infrastructure\News\NewsRepositoryFromXML;

interface FindNewsItemsInPeriod {
    public function inPeriod(Period $period, int $amount) : array;
}

interface FindNewsItemByLink {
    public function byLink(string $link) : NewsItem;
}

interface FindRecentNewsItems {
    public function recent(int $limit) : array;
}


final class NewsRepository
{
    private $inPeriod;
    private $newsItem;
    private $recentNewsItems;

    const News_Items_Per_Page = 12;
    const News_Items_Per_Archive_Page = 15;

    public function __construct(
        FindNewsItemsInPeriod $inPeriod, // WithMysql, withFakes, FromInMemory
        FindNewsItemByLink $newsItem,
        FindRecentNewsItems $newsItems
    ) {
        $this->inPeriod = $inPeriod;
        $this->newsItem = $newsItem;
        $this->recentNewsItems = $newsItems;
    }

    public function recent(int $limit = self::News_Items_Per_Page) :  array
    {
        return $this->recentNewsItems->recent($limit);
    }

    public function findInPeriod(Period $period) : array
    {
        return $this->inPeriod->inPeriod($period, self::News_Items_Per_Page);
    }

    public function findByLink(string $link) : NewsItem
    {
        return $this->newsItem->byLink($link);
    }
}
