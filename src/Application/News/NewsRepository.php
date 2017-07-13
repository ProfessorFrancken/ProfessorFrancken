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

interface NewsRepository
{
    const News_Items_Per_Page = 12;
    const News_Items_Per_Archive_Page = 15;

    public function search(Period $period = null, string $subject = null, string $author = null) : array;
    public function byLink(string $link) : NewsItem;
    public function recent(int $amount) : array;
}
