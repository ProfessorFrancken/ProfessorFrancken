<?php

declare(strict_types=1);

namespace Francken\Association\News\Http;

use Illuminate\View\View;
use Francken\Association\News\Http\Requests\SearchNewsRequest;
use Francken\Association\News\News;

final class NewsController
{
    public function index(): View
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

    public function archive(SearchNewsRequest $request): View
    {
        $news = News::recent()
            ->inPeriod($request->period())
            ->withSubject($request->subject())
            ->withAuthorName($request->author())
            ->paginate()
            ->appends($request->except('page'));

        return view('pages.association.news.archive')
            ->with('news', $news)
            ->with('breadcrumbs', [
                ['url' => '/association', 'text' => 'Association'],
                ['url' => action([self::class, 'index']), 'text' => 'News'],
                ['url' => action([self::class, 'archive']), 'text' => 'Archive'],
            ]);
    }

    public function show(News $news): View
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
}
