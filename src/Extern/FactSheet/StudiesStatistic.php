<?php

declare(strict_types=1);

namespace Francken\Extern\FactSheet;

use Illuminate\Support\Collection;

final class StudiesStatistic
{
    private Collection $studies;

    public function __construct(StudyStatistic ...$studies)
    {
        $relatedStudies = $this->filterUnrelatedStudies(collect($studies));

        $this->studies = $this->sort($relatedStudies);
    }

    public function studies() : Collection
    {
        return $this->studies;
    }

    public function total() : StudyStatistic
    {
        return $this->studies[0]::fromMultipleStatistics(
            "Total",
            ...$this->studies
        );
    }

    private function sort(Collection $studies) : Collection
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

    private function filterUnrelatedStudies(Collection $studies) : Collection
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
            function (StudyStatistic $study) use ($relatedStudies) : bool {
                return in_array($study->study(), $relatedStudies, true);
            }
        );

        if ($grouped->has(0)) {
            $grouped[1]->push(
                $studies[0]::fromMultipleStatistics("Other", ...$grouped[0])
            );
        }
        return $grouped[1];
    }
}
