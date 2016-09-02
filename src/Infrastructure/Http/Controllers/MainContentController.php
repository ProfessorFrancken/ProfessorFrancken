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
        return view('news', [
            'posts' => []
        ]);
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

}
