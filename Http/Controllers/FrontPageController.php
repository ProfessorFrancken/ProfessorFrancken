<?php

namespace Http\Controllers;

class FrontPageController extends Controller
{
    public function index()
    {
        return view('front-page');
    }
}
