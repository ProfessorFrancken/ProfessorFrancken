<?php

declare(strict_types=1);

namespace Francken\Lustrum\Http\Controllers;

use Francken\Lustrum\Adtchievement;
use Francken\Lustrum\Http\Requests\LustrumRequest;
use Francken\Lustrum\Pirate;
use Francken\Lustrum\PirateCrew;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PirateCrewController
{
    public function index(PirateCrew $pirateCrew) : View
    {
        $pirateCrew->load([
            'crewMembers' => function ($query) : void {
                // TODO: eager load in priatecrew member
                $query->withCount([
                    'earnedAdtchievements AS total_points' => function ($query) : void {
                        $query->select(\DB::raw("SUM(points) as total_points"));
                    }
                ]);
            },
            'earnedAdtchievements',
            'earnedAdtchievements.pirate',
            'earnedAdtchievements.adtchievement',
        ]);

        return view('lustrum.pirate-crews.index')
            ->with([
                'crew' => $pirateCrew,
                'adtchievements' => Adtchievement::all(),
                'breadcrumbs' => [
                    ['url' => '/lustrum', 'text' => 'Lustrum'],
                    [
                        'url' => action([self::class, 'index'], ['pirateCrew' => $pirateCrew->slug]),
                        'text' => $pirateCrew->name
                    ],
                ]
            ]);
    }

    public function store(PirateCrew $crew, LustrumRequest $request) : RedirectResponse
    {
        $member = $request->user()->member;

        if ($member === null) {
            return redirect()->action([self::class, 'index'])
                ->with('error', "Whoops");
        }

        $pirate = Pirate::initiate($member);
        $pirate->joinCrew($crew);

        $name = $crew->name;

        return redirect()->action([self::class, 'index'])
            ->with('success', "You've joined the {$name} crew!");
    }
}
