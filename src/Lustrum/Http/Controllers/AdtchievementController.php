<?php

declare(strict_types=1);

namespace Francken\Lustrum\Http\Controllers;

use Francken\Lustrum\EarnedAdtchievement;
use Illuminate\View\View;

final class AdtchievementController
{
    public function index() : View
    {
        $adtchievements = EarnedAdtchievement::with([
            'adtchievement',
            'pirate',
            'pirateCrew',
        ])->orderBy('created_at', 'desc')->get();

        return view('lustrum.adtchievements.index', [
            'adtchievements' => $adtchievements,
            'breadcrumbs' => [
                ['url' => '/lustrum', 'text' => 'Lustrum'],
                ['url' => action([self::class, 'index']), 'text' => 'Adtchievements'],
            ]
        ]);
    }
}
