<?php

declare(strict_types=1);

namespace Francken\Shared\Http\Controllers;

class FrontPageController extends Controller
{
    public function index()
    {
        return view('front-page');
    }
}
