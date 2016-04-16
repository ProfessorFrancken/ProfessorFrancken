<?php

namespace Francken\Infrastructure\Http\Controllers;

class FrontPageController extends Controller
{
    public function index()
    {
        return view('front-page');
    }
}
