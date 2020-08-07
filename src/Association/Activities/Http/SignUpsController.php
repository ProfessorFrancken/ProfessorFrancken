<?php

declare(strict_types=1);

namespace Francken\Association\Activities\Http;

use Francken\Association\Activities\Activity;
use Francken\Association\Activities\Http\Requests\SignUpRequest;
use Illuminate\Http\RedirectResponse;

final class SignUpsController
{
    public function store(SignUpRequest $request, Activity $activity) : RedirectResponse
    {
        $activity->signUp(
            $request->user()->member,
            $request->plusOnes(),
            $request->dietaryWishes(),
            $request->hasDriversLicense()
        );

        return redirect()->action([ActivitiesController::class, 'show'], ['activity' => $activity]);
    }
}
