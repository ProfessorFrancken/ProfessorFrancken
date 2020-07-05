<?php

declare(strict_types=1);

namespace Francken\Lustrum\Http\Controllers\Admin;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Francken\Association\LegacyMember;
use Francken\Lustrum\Adtchievement;
use Francken\Lustrum\Pirate;
use Francken\Lustrum\PirateCrew;
use Illuminate\Http\Request;

class PirateCrewController
{
    public function index(PirateCrew $pirateCrew): View
    {
        $pirateCrew->load([
                'crewMembers',
                // 'earnedAdtchievements',
                // 'earnedAdtchievements.pirate',
                // 'earnedAdtchievements.adtchievement',
        ]);


        return view('lustrum.admin.pirate-crews.index')
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

    public function store(PirateCrew $pirateCrew, Request $request): RedirectResponse
    {
        $member = LegacyMember::findOrFail($request->input('pirate.member_id'));

        if ($pirateCrew->crewMembers->where('member_id', $member->id)->first() !== null) {
            return redirect()->action([self::class, 'index'], ['pirateCrew' => $pirateCrew->slug]);
        }

        $pirateCrew->initiate($member);

        return redirect()->action([self::class, 'index'], ['pirateCrew' => $pirateCrew->slug]);
    }
}
