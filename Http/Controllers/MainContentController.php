<?php

namespace Http\Controllers;

class MainContentController extends Controller
{
    public function index()
    {
        return view('main');
    }

    public function news()
    {
        return view('news');
    }

    public function study()
    {
        return view('study');
    }

    public function career()
    {
        return view('career');
    }
}
