<?php

declare(strict_types=1);

namespace Francken\Association\News\Http;

use DateInterval;
use DateTimeImmutable;
use Francken\Association\News\Author;
use Francken\Association\News\Eloquent\News;
use Francken\Association\News\NewsContentCompiler;
use Francken\Association\News\NewsItem;
use Francken\Association\News\Repository as NewsRepository;
use Illuminate\Http\Request;
use League\Period\Period;

/**
 * Note that since the logic of news is quite trivial
 * we will simply use Eloquent here.
 */
final class AdminNewsController
{
    private $news;

    public function __construct(NewsRepository $news)
    {
        $this->news = $news;
    }

    public function index()
    {
        $drafts = $this->drafts();

        $news = $this->news->search(
            $this->periodForPagination(),
            request()->input('subject', null),
            request()->input('author', null)
        );

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
            'news' => NewsItem::empty(),
            'breadcrumbs' => [
                ['url' => action([static::class, 'index']), 'text' => 'News'],
                ['url' => action([static::class, 'create']), 'text' => 'Create'],
            ]
        ]);
    }

    public function store(Request $req)
    {
        $news = News::fromNewsItem(NewsItem::empty());
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

        return redirect('/admin' . $news->toNewsItem()->url());
    }

    public function show($link)
    {
        $news = $this->news->byLink($link);

        return view('admin.news.show', [
            'news' => $news,
            'breadcrumbs' => [
                ['url' => action([static::class, 'index']), 'text' => 'News'],
                ['url' => action([static::class, 'show'], $news->id()), 'text' => $news->title()],
            ]
        ]);
    }

    public function preview(string $item)
    {
        $newsItem = $this->news->byLink($item);

        return view('pages.association.news.item')
            ->with('newsItem', $newsItem);
    }

    public function update(Request $req, $link)
    {
        // We assume that the request gives all necessary data,
        // except for the author image.


        // Note that for read actions we normally use the news repository
        // however since now we want to make changes we will use an eloquent model
        // $news = News::byLink($link)->firstOrNew([]);
        $news = News::byLink($link)->firstOrFail();
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

        return redirect('/admin' . $news->toNewsItem()->url());
    }

    public function publish(Request $req, $link)
    {
        $news = News::byLink($link)->firstOrFail();
        $publishAt = new \DateTimeImmutable($req->input('publish-at'));

        $news->publish($publishAt);
        $news->save();

        return redirect('/admin' . $news->toNewsItem()->url());
    }

    public function archive(Request $req, $link)
    {
        $news = News::byLink($link)->firstOrFail();
        $news->archive();
        $news->save();
        dd($news);

        return redirect('/admin' . $news->toNewsItem()->url());
    }

    public function destroy($id)
    {
        // Note that for read actions we normally use the news repository
        // however since now we want to make changes we will use an eloquent model
        $news = News::byLink($id)->firstOrFail();
        $news->archive();
        $news->save();

        return redirect('/admin/association/news/' . $news->toNewsItem()->link());
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

    private function drafts()
    {
        return News::whereNull('published_at')->get()->map(function ($news) {
            return $news->toNewsItem();
        });
    }
}
