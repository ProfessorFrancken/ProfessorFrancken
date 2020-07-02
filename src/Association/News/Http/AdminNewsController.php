<?php

declare(strict_types=1);

namespace Francken\Association\News\Http;

use Francken\Association\News\Author;
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
            ->appends(request()->except('page'));

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

    public function store(Request $req)
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
                $req->input('author-name', $news->author_name),
                $req->input('author-photo', $news->author_photo)
            )
        );
        $news->changeTitle($req->input('title'));

        $news->changeContents(
            (new NewsContentCompiler())->content($req->input('content'))
        );
        $news->changeExerpt($req->input('exerpt'));

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

    public function update(Request $req, News $news)
    {
        // We assume that the request gives all necessary data,
        // except for the author image.


        // Note that for read actions we normally use the news repository
        // however since now we want to make changes we will use an eloquent model
        // $news = News::byLink($link)->firstOrNew([]);
        $news->changeAuthor(
            new Author(
                $req->input('author-name', $news->author_name),
                $req->input('author-photo', $news->author_photo)
            )
        );
        $news->changeTitle($req->input('title'));

        $news->changeContents(
            (new NewsContentCompiler())->content($req->input('content'))
        );
        $news->changeExerpt($req->input('exerpt'));

        $news->save();

        return redirect()->action([self::class, 'show'], ['news' => $news]);
    }

    public function publish(Request $req, News $news)
    {
        $publishAt = new \DateTimeImmutable($req->input('publish-at'));

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
