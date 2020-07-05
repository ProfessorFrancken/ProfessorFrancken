<?php

declare(strict_types=1);

namespace Francken\Extern\FactSheet;

use DateTimeImmutable;
use DB;
use Illuminate\Support\Collection;

final class FirstYearStudentsPerYear
{
    private Collection $years;

    public function __construct(Collection $years)
    {
        $this->years = $years;
    }

    public function handle()
    {
        return $this->years->map(function ($year) {
            $members = DB::connection('francken-legacy')
                ->table('leden')
                ->whereBetween('start_lidmaatschap', [new DateTimeImmutable("$year-08-01"), new DateTimeImmutable(($year + 1) . "-08-01")])
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
