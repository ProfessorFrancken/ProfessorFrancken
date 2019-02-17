<?php

declare(strict_types=1);

namespace Francken\Association\Activities;

use DateTimeImmutable;
use Illuminate\Support\Collection;

class ActivitiesSidebarComposer
{
    private $today;

    public function __construct()
    {
        $this->today = new DateTimeImmutable();
    }

    public function compose($view) : void
    {
        $viewData = $view->getData();
        $year = $viewData['selectedYear'] ?? (int) $this->today->format('Y');
        $month = $viewData['selectedMonth'] ?? (int)$this->today->format('m');

        $view->with([
            'selectedYear' => $year,
            'selectedMonth' => $month,
            'selectedDate' => DateTimeImmutable::createFromFormat(
                'Y-m', $year . '-' . $month
            ),
            'months' => $this->monthNames(),
            'visibleYears' => $this->visibleYears($year)
        ]);
    }

    private function visibleYears($year)
    {
        // Create list of visible years
        $yearsList = [];

        // Previous year
        if ($year > 2007) {
            $yearsList[] = $year - 1;
        }

        // Current year
        $yearsList[] = $year;

        // Next year
        if ($year <= (int)$this->today->format('Y')) {
            $yearsList[] = $year + 1;
        }

        return $yearsList;
    }

    private function monthNames() : Collection
    {
        return collect(range(1, 12))->map(function ($month) {
            return [
                'number' => date('m', mktime(0, 0, 0, $month, 1)),
                'name' => date('F', mktime(0, 0, 0, $month, 1))
            ];
        });
    }
}
