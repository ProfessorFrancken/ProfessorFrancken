<?php

declare(strict_types=1);

namespace Francken\Association\Activities\Http;

use DateTimeImmutable;
use Francken\Association\Activities\ActivitiesRepository;
use Illuminate\View\View;
use InvalidArgumentException;

final class ActivitiesPerMonthController
{
    private ActivitiesRepository $activities;

    public function __construct(ActivitiesRepository $activities)
    {
        $this->activities = $activities;
    }

    public function index(int $year, string $month) : View
    {
        $date = DateTimeImmutable::createFromFormat(
            'Y-m', $year . '-' . $month
        );

        if ($date === false) {
            throw new InvalidArgumentException("Invalid year and month combination");
        }

        return view('association.activities.index', [
            'activities' => $this->activities->inMonth($year, (int)$month),
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
