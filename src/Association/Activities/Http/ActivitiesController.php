<?php

declare(strict_types=1);

namespace Francken\Association\Activities\Http;

use Francken\Association\Activities\Activity;
use Francken\Shared\Clock\Clock;
use Illuminate\View\View;

final class ActivitiesController
{
    public function index(Clock $clock) : View
    {
        $activities = Activity::query()
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
}
