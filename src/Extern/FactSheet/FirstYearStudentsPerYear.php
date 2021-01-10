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

    public function handle() : Collection
    {
        return $this->years->map(function ($year) : array {
            $members = DB::connection('francken-legacy')
                ->table('leden')
                ->whereBetween('start_lidmaatschap', [new DateTimeImmutable("$year-07-01"), new DateTimeImmutable(($year + 1) . "-07-01")])
                ->where("jaar_van_inschrijving", $year)
                ->get();


            $studies = $members->groupBy('studierichting')
                ->map(fn ($students, $study) : StudentsPerStudy => new StudentsPerStudy($study, $students->count()))
                ->values();

            return [
                "year" => $year,
                "studies" => (new StudiesStatistic(...$studies))->studies(),
                "total" => $members->count()
            ];
        })->reverse();
    }
}
