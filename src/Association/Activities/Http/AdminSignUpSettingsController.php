<?php

declare(strict_types=1);

namespace Francken\Association\Activities\Http;

use Francken\Association\Activities\Activity;
use Francken\Association\Activities\Http\Requests\AdminSignUpSettingsRequest;
use Francken\Association\Activities\SignUpSettings;
use Francken\Association\LegacyMember;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final class AdminSignUpSettingsController
{
    public function create(Activity $activity) : View
    {
        return view('admin.association.activities.sign-up-settings.create')
            ->with([
                'activity' => $activity,
                'signUpSettings' => new SignUpSettings(),
                'members' => LegacyMember::autocomplete(),
                'breadcrumbs' => [
                    ['url' => action([AdminActivitiesController::class, 'index']), 'text' => 'Activities'],
                    ['url' => action([AdminActivitiesController::class, 'show'], ['activity' => $activity]), 'text' => $activity->name],
                    ['url' => action([static::class, 'create'], ['activity' => $activity]), 'text' => 'Add sign up settings'],
                ]
            ]);
    }


    public function store(AdminSignUpSettingsRequest $request, Activity $activity) : RedirectResponse
    {
        $activity->signUpSettings()->save(
            new SignUpSettings([
                'max_sign_ups' => $request->maxSignUps(),
                'costs_per_person' => $request->costsPerPerson(),
                'max_plus_ones_per_member' => $request->maxPlusOnesPerMember(),
                'ask_for_dietary_wishes' => $request->askForDietaryWishes(),
                'ask_for_drivers_license' => $request->askForDriversLicense(),
                'deadline_at' => $request->deadlineAt()
            ])
        );

        return redirect()->action([AdminActivitiesController::class, 'show'], ['activity' => $activity]);
    }

    public function edit(Activity $activity, SignUpSettings $signUpSettings) : View
    {
        return view('admin.association.activities.sign-up-settings.edit')
            ->with([
                'activity' => $activity,
                'signUpSettings' => $signUpSettings,
                'members' => LegacyMember::autocomplete(),
                'breadcrumbs' => [
                    ['url' => action([AdminActivitiesController::class, 'index']), 'text' => 'Activities'],
                    ['url' => action([AdminActivitiesController::class, 'show'], ['activity' => $activity]), 'text' => $activity->name],
                    ['url' => action([static::class, 'edit'], ['activity' => $activity, 'sign_up_settings' => $signUpSettings]), 'text' => 'Edit sign up settings'],
                ]
            ]);
    }

    public function update(AdminSignUpSettingsRequest $request, Activity $activity) : RedirectResponse
    {
        $activity->signUpSettings()->update(
            [
                'max_sign_ups' => $request->maxSignUps(),
                'costs_per_person' => $request->costsPerPerson(),
                'max_plus_ones_per_member' => $request->maxPlusOnesPerMember(),
                'ask_for_dietary_wishes' => $request->askForDietaryWishes(),
                'ask_for_drivers_license' => $request->askForDriversLicense(),
                'deadline_at' => $request->deadlineAt()
            ]
        );

        return redirect()->action([AdminActivitiesController::class, 'show'], ['activity' => $activity]);
    }

    public function destroy(Activity $activity) : RedirectResponse
    {
        $activity->signUpSettings()->delete();

        return redirect()->action([AdminActivitiesController::class, 'show'], ['activity' => $activity]);
    }
}
