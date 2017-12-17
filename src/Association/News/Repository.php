<?php

declare(strict_types=1);

namespace Francken\Association\News;

use Francken\Application\News\Author;
use Francken\Association\News\Repository;
use Francken\Application\News\NewsItemLink;
use Francken\Application\News\NewsItemPreview;
use Francken\Application\News\NewsItem;
use Francken\Domain\News\NewsId;
use Francken\Domain\News\AuthorId;
use Faker\Generator;
use League\Period\Period;
use DateTimeImmutable;
use Francken\Infrastructure\News\NewsRepositoryFromXML;

interface Repository
{
    const News_Items_Per_Page = 12;
    const News_Items_Per_Archive_Page = 15;

    /**
     * Finds a news item corresponding to the link given,
     * here link referes to the link used to view the 
     * item on our website, i.e. "17-09-29-borel-borel-borel-distribution"
     * 
     * @throws CouldNotFindNews
     */
    public function byLink(string $link) : NewsItem;

    public function search(Period $period = null, string $subject = null, string $author = null) : array;
    public function recent(int $amount) : array;
}