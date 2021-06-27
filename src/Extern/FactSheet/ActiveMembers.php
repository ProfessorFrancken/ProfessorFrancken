<?php

declare(strict_types=1);

namespace Francken\Extern\FactSheet;

use Illuminate\Support\Collection;

final class ActiveMembers
{
    private Collection $members;

    public function __construct(Collection $members)
    {
        $this->members = $members;
    }

    public function total() : int
    {
        return $this->members->count();
    }

    public function internationals() : int
    {
        return $this->members->where('is_nederlands', 0)
            ->where('nederlands', 0)
            ->count();
    }

    public function studies() : Collection
    {
        $studies = $this->members->groupBy('studierichting')
            ->map(
                fn ($students, $study) : StudyStatistic =>
                new StudentsPerStudy($study, $students->count())
            );

        return (new StudiesStatistic(...$studies->values()))->studies();
    }

    public function genders() : Collection
    {
        return $this->members->groupBy('geslacht');
    }
}
