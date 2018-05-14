<?php

declare(strict_types=1);

namespace Francken\Association\Activities;

use DateTimeImmutable;

class ActivitiesSidebarComposer {

    private $today;

    public function __construct()
    {
        $this->today = new DateTimeImmutable;
    }

    public function compose($view)
    {
        $year = isset($view->selectedYear)
            ? $view->selectedYear
            : ((int) $this->today->format('Y'));

        $months = collect(range(1, 12))->map(function ($month) {
            return [
                'number' => $month,
                'name' => date('F', mktime(0, 0, 0, $month, 1))
            ];
        });

        $visibleYears = $this->getVisibleYears($year);

        $view->with([
            'selectedYear' => $year,
            'selectedMonth' => (int)$this->today->format('m'),
            'months' => $months,
            'visibleYears' => $visibleYears
        ]);
    }

    private function getVisibleYears($year)
    {
        // Create list of visible years
        $yearsList = [];

        // Previous year
        if($year > 2007) {
            $yearsList[] = $year - 1;
        }

        // Current year
        $yearsList[] = $year;

        // Next year
        if($year <= (int)$this->today->format('Y')) {
            $yearsList[] = $year + 1;
        }

        return $yearsList;
    }
}
