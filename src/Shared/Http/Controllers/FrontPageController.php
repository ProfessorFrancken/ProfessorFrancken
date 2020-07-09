<?php

declare(strict_types=1);

namespace Francken\Shared\Http\Controllers;

use Illuminate\View\View;

class FrontPageController extends Controller
{
    public function index() : View
    {
        return view('front-page');
    }
}
