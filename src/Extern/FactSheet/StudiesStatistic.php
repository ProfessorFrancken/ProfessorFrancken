<?php

declare(strict_types=1);

namespace Francken\Extern\FactSheet;

use Illuminate\Support\Collection;

final class StudiesStatistic
{
    // Auto filter unrelated studies into others
    // sort by important
    // add total?
    private $studies;

    public function __construct(StudyStatistic ...$studies)
    {
        $this->studies = $this->sort(
            $this->filterUnrelatedStudies(
                collect($studies)
            )
        );
    }

    public function studies()
    {
        return $this->studies;
    }

    public function total()
    {
        return $this->studies[0]::fromMultipleStatistics(
            "Total",
            ...$this->studies
        );
    }

    private function sort(Collection $studies)
    {
        $relatedStudies = [
            "Technische Natuurkunde",
            "Natuurkunde",
            "Nanoscience",
            "Sterrenkunde",
            "(Technische) Wiskunde",
            "(Technische) Scheikunde",
            "Other"
        ];

        return $studies->sortBy(
            function (StudyStatistic $study) use ($relatedStudies) {
                return array_search($study->study(), $relatedStudies, true);
            }
        );
    }

    private function filterUnrelatedStudies(Collection $studies)
    {
        $relatedStudies = [
            "Technische Natuurkunde",
            "Natuurkunde",
            "Nanoscience",
            "Sterrenkunde",
            "(Technische) Wiskunde",
            "(Technische) Scheikunde",
        ];

        if ($studies->isEmpty()) {
            return collect();
        }

        $grouped = $studies->groupBy(
            function (StudyStatistic $study) use ($relatedStudies) {
                return in_array($study->study(), $relatedStudies, true);
            }
        );

        return $grouped[1]->push(
            $studies[0]::fromMultipleStatistics("Other", ...$grouped[0])
        );
    }
}

interface StudyStatistic
{
    public function study() : string;

    /*
     * Used to create "Total" and "Other" statistics
     */
    public static function fromMultipleStatistics(string $name, ...$others);
}
