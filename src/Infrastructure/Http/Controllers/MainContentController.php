<?php

declare(strict_types=1);

namespace Francken\Infrastructure\Http\Controllers;

use DB;
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
        // $posts = PostList::paginate(10);
        return view('news'); //, [
            // 'posts' => $posts
        // ]);
    }

    public function news()
    {
        return view('news', [
            'posts' => []
        ]);
    }

    public function blog()
    {
        return view('news', [
            'posts' => []
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

    /**
     * This is a quick and dirty way of making it easy to add new (static pages)
     * it comes with the disadvantage that you cannot control the data passed to
     * the views, though you can possibly fix this by using view composers
     */
    public function page(string $page)
    {
        try {
            return view('pages.' . $page, [
                'posts' => []
            ]);
        } catch (\InvalidArgumentException $e) {
            return view('errors.404');
        }
    }
}
