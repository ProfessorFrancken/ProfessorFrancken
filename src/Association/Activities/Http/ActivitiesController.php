<?php

declare(strict_types=1);

namespace Francken\Association\Activities\Http;

use Francken\Association\Activities\Activity;
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
            ->limit(20)
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

    public function show(Request $request, Activity $activity) : View
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
                ['url' => action(
                    [ActivitiesPerMonthController::class, 'index'],
                    ['year' => $activity->start_date->format('Y'), 'month' => $activity->start_date->format('m')]
                ), 'text' => $activity->start_date->format('F') . ' ' . $activity->start_date->format('Y')],
                ['url' => action([self::class, 'show'], ['activity' => $activity]), 'text' => $activity->name],
            ],
        ]);
    }

    public function redirect(Activity $activity) : RedirectResponse
    {
        return redirect()->action([self::class, 'show'], ['activity' => $activity]);
    }
}
