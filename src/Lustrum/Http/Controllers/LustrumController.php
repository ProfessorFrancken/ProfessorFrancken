<?php

declare(strict_types=1);

namespace Francken\Lustrum\Http\Controllers;

use Francken\Lustrum\PirateCrew;
use Illuminate\View\View;

class LustrumController
{
    public function index() : View
    {
        $blueBeards = PirateCrew::where('name', 'Blue beards')->firstOrFail();
        $redBeards = PirateCrew::where('name', 'Red beards')->firstOrFail();

        return view('lustrum.index', [
            'blue_beards_points' => $blueBeards->total_points,
            'red_beards_points' => $redBeards->total_points
        ]);
    }
}
