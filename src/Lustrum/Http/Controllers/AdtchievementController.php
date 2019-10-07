<?php

declare(strict_types=1);

namespace Francken\Lustrum\Http\Controllers;

use Francken\Lustrum\EarnedAdtchievement;

final class AdtchievementController
{
    public function index()
    {
        $adtchievements = EarnedAdtchievement::with([
            'adtchievement',
            'pirate',
            'pirateCrew',
        ])->get();

        return view('lustrum.adtchievements.index', [
            'adtchievements' => $adtchievements,
            'breadcrumbs' => [
                ['url' => '/lustrum', 'text' => 'Lustrum'],
                ['url' => action([self::class, 'index']), 'text' => 'Adtchievements'],
            ]
        ]);
    }
}
