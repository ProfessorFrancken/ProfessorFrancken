<?php

declare(strict_types=1);

namespace Francken\Extern\FactSheet;

use DB;
use Illuminate\Support\Collection;
use DateTime;
use DateTimeImmutable;

final class FirstYearStudentsPerYear
{
    public function __construct(Collection $years)
    {
        $this->years = $years;
    }

    public function handle()
    {
        return $this->years->map(function ($year) {
            $members = DB::connection('francken-legacy')
                ->table('leden')
                ->whereBetween('start_lidmaatschap', [new DateTime("$year-08-01"), new DateTime(($year + 1)."-08-01")])
                ->where("jaar_van_inschrijving", $year)
                ->get();


            $studies = $members->groupBy('studierichting')
                ->map(function ($students, $study) {
                    return new StudentsPerStudy($study, $students->count());
                })
                ->values();

            return [
                "year" => $year,
                "studies" => (new StudiesStatistic(...$studies))->studies(),
                "total" => $members->count()
            ];
        })->reverse();
    }
}
