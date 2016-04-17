<?php

namespace Francken\Infrastructure\Http\Controllers;

use App\ReadModel\PostList\PostList;

class MainContentController extends Controller
{
    public function index()
    {
        return view('main');
    }

    public function news()
    {
        $posts = PostList::paginate(10);
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
}
