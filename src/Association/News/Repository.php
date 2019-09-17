<?php

declare(strict_types=1);

namespace Francken\Association\News;

use League\Period\Period;

interface Repository
{
    public const News_Items_Per_Page = 12;
    public const News_Items_Per_Archive_Page = 15;

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
