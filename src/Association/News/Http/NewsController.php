<?php

declare(strict_types=1);

namespace Francken\Association\News\Http;

use DateInterval;
use DateTimeImmutable;
use Francken\Association\News\News;
use League\Period\Period;

final class NewsController
{
    public function index()
    {
        $news = News::recent()->paginate(12);
   
        return view('pages.association.news')
            ->with([
                'news' => $news,
                'breadcrumbs' => [
                    ['url' => '/association', 'text' => 'Association'],
                    ['url' => action([self::class, 'index']), 'text' => 'News'],
                ]
            ]);
    }

    public function archive()
    {
        $news = News::recent()
            ->inPeriod($this->periodForPagination())
            ->withSubject(request()->input('subject', null))
            ->withAuthorName(request()->input('author', null))
            ->paginate()
            ->appends(request()->except('page'));

        return view('pages.association.news.archive')
            ->with('news', $news)
            ->with('breadcrumbs', [
                ['url' => '/association', 'text' => 'Association'],
                ['url' => action([self::class, 'index']), 'text' => 'News'],
                ['url' => action([self::class, 'archive']), 'text' => 'Archive'],
            ]);
    }

    public function show(News $news)
    {
        return view('pages.association.news.item')
            ->with([
                'newsItem' => $news,
                'previous' => $news->previous(),
                'next' => $news->next(),
                'breadcrumbs' => [
                    ['url' => '/association', 'text' => 'Association'],
                    ['url' => action([self::class, 'index']), 'text' => 'News'],
                    ['text' => $news->title],
                ]
            ]);
    }

    private function periodForPagination() : Period
    {
        // Enable artificial pagination
        if (request()->has('before') && request()->has('after')) {
            $before_string = str_replace('/', '', request()->input('before', '-2 years'));
            $before = new DateTimeImmutable($before_string);

            $after = new DateTimeImmutable(request()->input('after', 'now'));

            return new Period(
                $after,
                $before
            );
        }

        if (request()->has('before')) {
            $before_string = str_replace('/', '', request()->input('before', '-2 years'));
            $before = new DateTimeImmutable($before_string);

            return new Period(
                $before->sub(DateInterval::createFromDateString('2 years')),
                $before
            );
        }

        if (request()->has('after')) {
            $after_string = str_replace('/', '', request()->input('after', 'now'));
            $after = new DateTimeImmutable($after_string);

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
