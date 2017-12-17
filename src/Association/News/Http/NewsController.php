<?php

declare(strict_types=1);

namespace Francken\Association\News\Http;

use DateInterval;
use DateTimeImmutable;
use Francken\Association\News\Repository as NewsRepository;
use League\Period\Period;

final class NewsController
{
    private $news;

    public function __construct(NewsRepository $news)
    {
        $this->news = $news;
    }

    public function index()
    {
        return view('pages.association.news')
            ->with('news', $this->news->recent(12));
    }

    public function archive()
    {
        $news = $this->news->search(
            $this->periodForPagination(),
            request()->input('subject', null),
            request()->input('author', null)
        );

        return view('pages.association.news.archive')
            ->with('news', $news);
    }

    public function show($link)
    {
        $newsItem = $this->news->byLink($link);

        return view('pages.association.news.item')
            ->with('newsItem', $newsItem);
    }

    private function periodForPagination() : Period
    {
        // Enable artificial pagination
        if (request()->has('before') && request()->has('after')) {
            $before = new DateTimeImmutable(request()->input('before', '-2 years'));
            $after = new DateTimeImmutable(request()->input('after', 'now'));

            return new Period(
                $after,
                $before
            );
        }

        if (request()->has('before')) {
            $before = new DateTimeImmutable(request()->input('before', '-2 years'));

            return new Period(
                $before->sub(DateInterval::createFromDateString('2 years')),
                $before
            );
        }

        if (request()->has('after')) {
            $after = new DateTimeImmutable(request()->input('after', 'now'));

            return new Period(
                $after,
                $after->add(DateInterval::createFromDateString('2 years'))
            );
        }

        return new Period(
            $start = new DateTimeImmutable('-2 years'),
            $end = new DateTimeImmutable('now')
        );
    }
}
