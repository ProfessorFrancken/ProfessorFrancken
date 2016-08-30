<?php

namespace Francken\Infrastructure\Http\Controllers;

use Francken\Application\ReadModel\PostList\PostList;

class MainContentController extends Controller
{
    public function index()
    {
        return view('main');
    }

    public function about()
    {
        return view('about');
    }

    public function post()
    {
        $posts = PostList::paginate(10);
        return view('news', [
            'posts' => $posts
        ]);
    }

    public function news()
    {
        $posts = PostList::news()->paginate(10);
        return view('news', [
            'posts' => $posts
        ]);
    }

    public function blog()
    {
        $posts = PostList::blog()->paginate(10);
        return view('news', [
            'posts' => $posts
        ]);
    }

    public function study()
    {
        return view('study');
    }

    public function career()
    {
        return view('career');
    }

    public function association()
    {
        return view('association');
    }

    public function boards()
    {
        return view('boards');
    }

    public function history()
    {
        return view('history');
    }

}
