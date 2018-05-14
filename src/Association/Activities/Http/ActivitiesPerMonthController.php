<?php

declare(strict_types=1);

namespace Francken\Association\Activities\Http;

use DateInterval;
use DateTimeImmutable;
use League\Period\Period;
use Francken\Association\Activities\ActivitiesRepository;

final class ActivitiesPerMonthController
{
    private $activities;

    public function __construct(ActivitiesRepository $activities)
    {
        $this->activities = $activities;
    }

    public function index(int $year, int $month)
    {
        return view('association.activities.index')
            ->with('activities', $this->activities->inMonth($year, $month))
            ->with('selectedYear', $year)
            ->with('selectedMonth', $month)
            ->with('searchTimeRange', true);
    }
}
