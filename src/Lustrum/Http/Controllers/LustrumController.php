<?php

declare(strict_types=1);

namespace Francken\Lustrum\Http\Controllers;

class LustrumController
{
    public function index()
    {
        return view('lustrum.index');
    }
}
