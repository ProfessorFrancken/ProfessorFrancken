<?php

declare(strict_types=1);

namespace Francken\Lustrum\Http\Controllers\Admin;

use Francken\Lustrum\Adtchievement;
use Francken\Lustrum\EarnedAdtchievement;
use Francken\Lustrum\Pirate;
use Francken\Lustrum\PirateCrew;
use Illuminate\Http\Request;

class PirateAdtchievementsController
{
    public function store(PirateCrew $pirateCrew, Request $request)
    {
        $adtchievement = Adtchievement::findOrFail($request->adtchievement_id);

        $pirate = Pirate::where('member_id', $request->input('adtchievement.member_id'))
            ->firstOrFail();

        $adtchievement->earnBy(
            $pirate,
            $request->input('reason') ?? ''
        );

        return redirect()->action([PirateCrewController::class, 'index'], ['pirateCrew' => $pirateCrew->slug]);
    }

    public function remove(PirateCrew $pirateCrew, EarnedAdtchievement $adtchievement)
    {
        $adtchievement->delete();

        return redirect()->action([PirateCrewController::class, 'index'], ['pirateCrew' => $pirateCrew->slug]);
    }
}
