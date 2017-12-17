<?php

declare(strict_types=1);

namespace Francken\Association\News\Eloquent;

use Francken\Association\News\Author;
use Francken\Association\News\NewsItem;
use Francken\Association\News\Repository as NewsRepository;
use Francken\Association\News\CouldNotFindNews;
use League\Period\Period;

final class Repository implements NewsRepository
{
    public function search(Period $period = null, string $subject = null, string $author = null) : array
    {
        return News::recent()
            ->inPeriod($period)
            ->withSubject($subject)
            ->withAuthorName($author)
            ->get()
            ->map(
                function (News $news) {
                    return $news->toNewsItem();
                }
            )
            ->toArray();
    }

    public function byLink(string $link) : NewsItem
    {
        $news = News::byLink($link)->first();

        if (is_null($news)) {
            throw CouldNotFindNews::forLink($link);
        }

        return $news->toNewsItem();
    }

    public function recent(int $amount) : array
    {
        return News::recent()
            ->take($amount)
            ->get()
            ->map(
                function (News $news) {
                    return $news->toNewsItem();
                }
            )
            ->toArray();
    }
}