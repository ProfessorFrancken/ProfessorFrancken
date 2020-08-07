<?php

declare(strict_types=1);

namespace Francken\Association\Activities\Http;

use Francken\Association\Activities\Activity;
use Francken\Association\Activities\Http\Requests\SignUpRequest;
use Francken\Shared\Clock\Clock;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class ActivitiesController
{
    public function index(Clock $clock) : View
    {
        $activities = Activity::query()
            ->with(['signUpSettings', 'signUps', 'signUps.member'])
            ->after($clock->now())
            ->orderBy('start_date', 'asc')
            ->limit(5)
            ->get();

        return view('association.activities.index', [
            'activities' => $activities,
            'searchTimeRange' => false,
            'breadcrumbs' => [
                ['url' => '/association/', 'text' => 'Association'],
                ['url' => '/association/activities/', 'text' => 'Activities'],
            ],
        ]);
    }

    public function show(Request $request, Activity $activity)
    {
        $activity->load(['signUps.member']);
        $account = $request->user();
        return view('association.activities.show', [
            'activity' => $activity,
            'account' => $account,
            'searchTimeRange' => false,
            'breadcrumbs' => [
                ['url' => '/association/', 'text' => 'Association'],
                ['url' => action([self::class, 'index']), 'text' => 'Activities'],
                ['url' => action([self::class, 'show'], ['activity' => $activity]), 'text' => $activity->name],
            ],
        ]);
    }

    public function redirect(Activity $activity) : RedirectResponse
    {
        return redirect()->action([self::class, 'show'], ['activity' => $activity]);
    }

    public function store(SignUpRequest $request, Activity $activity) : RedirectResponse
    {
        $activity->signUp(
            $request->user()->member,
            $request->plusOnes(),
            $request->dietaryWishes(),
            $request->hasDriversLicense()
        );

        return redirect()->action([self::class, 'show'], ['activity' => $activity]);
    }
}
