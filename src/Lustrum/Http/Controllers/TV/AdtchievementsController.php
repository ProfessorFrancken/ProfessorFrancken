<?php

declare(strict_types=1);

namespace Francken\Lustrum\Http\Controllers\TV;

use Francken\Lustrum\EarnedAdtchievement;

class AdtchievementsController
{
    public function index()
    {
        $adtchievements = EarnedAdtchievement::with([
            'adtchievement',
            'pirate',
            'pirateCrew',
        ])->orderBy('created_at', 'desc')->take(5)->get();

        return view('lustrum.tv.adtchievements', [
            'adtchievements' => $adtchievements,
        ]);
    }
}
