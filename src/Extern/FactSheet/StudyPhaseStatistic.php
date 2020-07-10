<?php

declare(strict_types=1);

namespace Francken\Extern\FactSheet;

final class StudyPhaseStatistic implements StudyStatistic
{
    private string $study;
    private int $bachelor = 0;
    private int $master = 0;

    public function __construct(
        string $study,
        int $amountOfBachelorStudents,
        int $amountOfMasterStudents
    ) {
        $this->study = $study;
        $this->bachelor = $amountOfBachelorStudents;
        $this->master = $amountOfMasterStudents;
    }

    public function study() : string
    {
        return $this->study;
    }

    public function amount() : int
    {
        return $this->bachelor() + $this->master();
    }

    public function bachelor() : int
    {
        return $this->bachelor;
    }

    public function master() : int
    {
        return $this->master;
    }

    public static function fromMultipleStatistics(string $name, StudyStatistic ...$others) : StudyStatistic
    {
        $studies = collect($others)->filter(fn (StudyStatistic $study) => $study instanceof self);
        return new self(
            $name,
            $studies->reduce(
                fn (int $amount, self $study) : int => $amount + $study->bachelor(),
                0
            ),
            $studies->reduce(
                fn (int $amount, self $study) : int => $amount + $study->master(),
                0
            )
        );
    }
}
