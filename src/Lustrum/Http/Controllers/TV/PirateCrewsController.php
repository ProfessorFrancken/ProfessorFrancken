<?php

declare(strict_types=1);

namespace Francken\Lustrum\Http\Controllers\TV;

use Francken\Lustrum\PirateCrew;

class PirateCrewsController
{
    public function index()
    {
        $blue_beards = PirateCrew::where('name', 'Blue beards')->firstOrFail();
        $red_beards = PirateCrew::where('name', 'Red beards')->firstOrFail();

        return view('lustrum.tv.pirate_crews', [
            'blue_beards' => $blue_beards,
            'red_beards' => $red_beards
        ]);
    }
}
