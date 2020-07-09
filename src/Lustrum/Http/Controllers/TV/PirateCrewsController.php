<?php

declare(strict_types=1);

namespace Francken\Lustrum\Http\Controllers\TV;

use Francken\Lustrum\PirateCrew;

class PirateCrewsController
{
    public function index()
    {
        $blueBeards = PirateCrew::where('name', 'Blue beards')->firstOrFail();
        $redBeards = PirateCrew::where('name', 'Red beards')->firstOrFail();

        return view('lustrum.tv.pirate_crews', [
            'blue_beards' => $blueBeards,
            'red_beards' => $redBeards
        ]);
    }
}
