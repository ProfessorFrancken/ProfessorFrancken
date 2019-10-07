<?php

declare(strict_types=1);

namespace Francken\Lustrum\Http\Controllers;

use Francken\Lustrum\PirateCrew;

class LustrumController
{
    public function index()
    {
        $blue_beards = PirateCrew::where('name', 'Blue beards')->firstOrFail();
        // $red_beards = PirateCrew::where('name', 'Red beards')->firstOrFail();
        $red_beards = PirateCrew::where('name', 'Blue beards')->firstOrFail();

        return view('lustrum.index', [
            'blue_beards_points' => $blue_beards->total_points,
            'red_beards_points' => $red_beards->total_points
        ]);
    }
}
