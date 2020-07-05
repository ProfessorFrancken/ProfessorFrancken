<?php

declare(strict_types=1);

namespace Francken\Association\News\Http;

use DateTimeImmutable;
use Francken\Association\News\Author;
use Francken\Association\News\Http\Requests\AdminNewsRequest;
use Francken\Association\News\Http\Requests\SearchNewsRequest;
use Francken\Association\News\News;
use Francken\Association\News\NewsContentCompiler;
use Illuminate\Http\Request;

/**
 * Note that since the logic of news is quite trivial
 * we will simply use Eloquent here.
 */
final class AdminNewsController
{
    public function index(SearchNewsRequest $request)
    {
        $drafts = $this->drafts();

        $news = News::recent()
            ->inPeriod($request->period())
            ->withSubject($request->subject())
            ->withAuthorName($request->author())
            ->paginate()
            ->appends($request->except('page'));

        return view('admin.news.index', [
            'news' => $news,
            'drafts' => $drafts,
            'breadcrumbs' => [
                ['url' => action([static::class, 'index']), 'text' => 'News'],
            ]
        ]);
    }

    public function create()
    {
        return view('admin.news.create', [
            'news' => new News(),
            'breadcrumbs' => [
                ['url' => action([static::class, 'index']), 'text' => 'News'],
                ['url' => action([static::class, 'create']), 'text' => 'Create'],
            ]
        ]);
    }

    public function store(AdminNewsRequest $request)
    {
        $news = new News([
            'title' => '',
            'exerpt' => '',
            'author_name' => '',
            'author_photo' => '',
            'source_contents' => '',
            'compiled_contents' => '',
            'related_news_items' => [],
        ]);
        $news->changeAuthor(
            new Author(
                $request->authorName(),
                $request->authorPhoto()
            )
        );
        $news->changeTitle($request->title());

        $news->changeContents(
            (new NewsContentCompiler())->content($request->content())
        );
        $news->changeExerpt($request->exerpt());

        $news->save();

        return redirect()->action([static::class, 'show'], ['news' => $news]);
    }

    public function show(News $news)
    {
        return view('admin.news.show', [
            'news' => $news,
            'breadcrumbs' => [
                ['url' => action([static::class, 'index']), 'text' => 'News'],
                ['url' => action([static::class, 'show'], ['news' => $news]), 'text' => $news->title],
            ]
        ]);
    }

    public function preview(News $news)
    {
        return view('pages.association.news.item')
            ->with([
                'newsItem' => $news,
                'previous' => null,
                'next' => null,
            ]);
    }

    public function update(AdminNewsRequest $request, News $news)
    {
        $news->changeAuthor(
            new Author(
                $request->authorName(),
                $request->authorPhoto()
            )
        );
        $news->changeTitle($request->title());

        $news->changeContents(
            (new NewsContentCompiler())->content($request->content())
        );
        $news->changeExerpt($request->exerpt());

        $news->save();

        return redirect()->action([self::class, 'show'], ['news' => $news]);
    }

    public function publish(Request $req, News $news)
    {
        $publishAt = new DateTimeImmutable($req->input('published_at'));

        $news->publish($publishAt);
        $news->save();

        return redirect()->action([self::class, 'show'], ['news' => $news]);
    }

    public function archive(News $news)
    {
        $news->archive();
        $news->save();

        return redirect()->action([self::class, 'index']);
    }

    public function destroy(News $news)
    {
        $news->archive();
        $news->save();

        return redirect()->action([self::class, 'show'], ['news' => $news]);
    }
        
    private function drafts()
    {
        return News::whereNull('published_at')->get();
    }
}
