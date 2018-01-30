<?php

declare(strict_types=1);

namespace Francken\Association\News\InMemory;

use DateTimeImmutable;
use Francken\Association\News\Repository as NewsRepository;
use Francken\Association\News\CouldNotFindNews;
use Francken\Association\News\NewsItem;
use Francken\Association\News\NewsItemLink;
use Francken\Domain\News\AuthorId;
use Francken\Domain\News\NewsId;
use League\Period\Period;

final class Repository implements NewsRepository
{
    private $news;

    public function __construct(array $news = [])
    {
        $this->news = collect((function (NewsItem... $news) {
            return $news;
        })(...$news))
        ->sortByDesc(function ($news) {
            return $news->publicationDate()->getTimestamp();
        })->values();
    }

    public function search(Period $period = null, string $subject = null, string $author = null) : array
    {
        $searchBySubject = function (NewsItem $news) use ($subject) {
            if (is_null($subject)) {
                return true;
            }

            return str_contains($news->title(), $subject);
        };

        $searchByAuthor = function (NewsItem $news) use ($author) {
            if (is_null($author)) {
                return true;
            }

            return str_contains($news->authorName(), $author);
        };

        $searchByPeriod = function (NewsItem $news) use ($period) {
            if (is_null($period)) {
                return true;
            }

            return $period->contains($news->publicationDate());
        };

        // return $this->news->toArray();
        return $this->news
            ->filter($searchBySubject)
            ->filter($searchByAuthor)
            ->filter($searchByPeriod)
            // ->take(NewsRepository::News_Items_Per_Archive_Page)
            ->toArray();
    }

    public function byLink(string $link) : NewsItem
    {
        $item = $this->news->filter(function (NewsItem $item) use ($link) {
            return $item->link() == $link;
        })->first();

        if (is_null($item)) {
            throw CouldNotFindNews::forLink($link);
        }

        return $item;
    }

    public function recent(int $amount) : array
    {
        return $this->news->sortByDesc(function (NewsItem $news) {
            return $news->publicationDate();
        })->take($amount)->toArray();
    }
}