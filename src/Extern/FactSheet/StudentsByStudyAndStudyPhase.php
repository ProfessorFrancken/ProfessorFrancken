<?php

declare(strict_types=1);

namespace Francken\Extern\FactSheet;

use DateTimeImmutable;
use DB;
use Illuminate\Support\Collection;

final class StudentsByStudyAndStudyPhase
{
    private DateTimeImmutable $today;

    public function __construct(DateTimeImmutable $today)
    {
        $this->today = $today;
    }

    public function handle() : StudiesStatistic
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

    private function studyPhaseStatistics(Collection $students) : Collection
    {
        return $students->groupBy(fn ($student) => $student->studierichting)->map(function ($students, $study) : StudyPhaseStatistic {
            $probablyDoingBachelors = fn ($student) : bool => ((int)$student->jaar_van_inschrijving) >= (int)$this->today->format('Y') - 5;

            return new StudyPhaseStatistic(
                $study,
                $students->filter($probablyDoingBachelors)->count(),
                $students->reject($probablyDoingBachelors)->count()
            );
        });
    }
}
