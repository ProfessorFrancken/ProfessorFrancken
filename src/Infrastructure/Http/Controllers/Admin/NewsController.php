<?php

declare(strict_types=1);

namespace Francken\Infrastructure\Http\Controllers\Admin;

use DB;
use DateInterval;
use DateTimeImmutable;
use Francken\Application\News\NewsRepository;
use Francken\Application\ReadModel\PostList\PostList;
use Francken\Domain\Posts\Events\PostWritten;
use Francken\Domain\Posts\Post;
use Francken\Domain\Posts\PostCategory;
use Francken\Domain\Posts\PostId;
use Francken\Domain\Posts\PostRepository;
use Francken\Infrastructure\Http\Controllers\Controller;
use Illuminate\Http\Request;
use League\Period\Period;

class NewsController extends Controller
{

    private $news;

    public function __construct(NewsRepository $news)
    {
        $this->news = $news;
    }

    public function index()
    {
        $news = $this->news->search(
            $this->periodForPagination(),
            request()->input('subject', null),
            request()->input('author', null)
        );


        return view('admin.news.index', [
            'news' => $news
        ]);
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $req, PostRepository $repo)
    {
        //Validate doesn't work?
        // $this->validate($req, [
        //     'title' => 'required|max:255',
        //     'content' => 'required',
        //     'type' => 'in:blog,news',
        //     'publishes_at' => 'date',
        // ]);

        $id = PostId::generate();

        $post = Post::createDraft(
            $id,
            $req->input('title'),
            $req->input('content'),
            PostCategory::fromString($req->input('type'))
        );

        $post->setPublishDate(\Carbon\Carbon::now()); /// @todo

        $repo->save($post);

        return redirect('/admin/news');
    }

    public function show($link)
    {
        $news = $this->news->byLink($link);

        return view('admin.news.show', [
            'news' => $news
        ]);
    }

    public function edit($id)
    {
        $post = DB::table('posts')->where('id', $id)->first();

        return view('admin.news.edit', [
            'post' => $post
        ]);
    }

    public function update(Request $req, PostRepository $repo, $id)
    {
        dd($req->all());
        $post = $repo->load($id);
        $post->edit($req->input('name'), $req->input('goal'));

        $repo->save($post);

        return redirect('/admin/committee/' . $id);
    }

    public function destroy($id, PostRepository $repo)
    {
        $post = $repo->load($id);
        $post->remove();
        return redirect('/admin/post');
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
