<?php

declare(strict_types=1);

namespace Francken\Extern\FactSheet;

use DB;
use DateTimeImmutable;

final class StudentsByStudyAndStudyPhase
{
    private $today;

    public function __construct(DateTimeImmutable $today)
    {
        $this->today = $today;
    }

    public function handle()
    {
        $students = DB::connection('francken-legacy')->table('leden')
                  ->where('is_lid', true)
                  ->whereIn('type_lid', ['Student RUG', 'Student'])
                  // ->where('jaar_van_inschrijving', '>', $this->today->format('Y') - 8)
                  ->get();

        return (new StudiesStatistic(
            ...$this->studyPhaseStatistics($students)->values()
        ));
    }

    private function studyPhaseStatistics($students)
    {
        return $students->groupBy(function ($student) {
            return $student->studierichting;
        })->map(function ($students, $study) {
            $probablyDoingBachelors = function ($student) {
                return ((int)$student->jaar_van_inschrijving) >= (int)$this->today->format('Y') - 5;
            };

            return new StudyPhaseStatistic(
                $study,
                $students->filter($probablyDoingBachelors)->count(),
                $students->reject($probablyDoingBachelors)->count()
            );
        });
    }
}
