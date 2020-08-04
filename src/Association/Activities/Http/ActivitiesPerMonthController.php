<?php

declare(strict_types=1);

namespace Francken\Association\Activities\Http;

use DateTimeImmutable;
use Francken\Association\Activities\Activity;
use Illuminate\View\View;
use InvalidArgumentException;

final class ActivitiesPerMonthController
{
    public function index(string $year, string $month) : View
    {
        $date = DateTimeImmutable::createFromFormat(
            'Y-m', $year . '-' . $month
        );

        if ($date === false) {
            throw new InvalidArgumentException("Invalid year and month combination");
        }

        $activities = Activity::query()
            ->orderBy('start_date', 'asc')
            ->whereMonth('start_date', $month)
            ->whereYear('start_date', $year)
            ->get();

        return view('association.activities.index', [
            'activities' => $activities,
            'selectedYear' => $year,
            'selectedMonth' => $month,
            'selectedDate' => $date,
            'searchTimeRange' => true,
            'breadcrumbs' => [
                ['url' => '/association/', 'text' => 'Association'],
                ['url' => '/association/activities/', 'text' => 'Activities'],
                ['text' => $date->format('F / Y')],
            ],
        ]);
    }
}
