<?php

declare(strict_types=1);

namespace Francken\Extern\FactSheet;

final class StudyPhaseStatistic implements StudyStatistic
{
    private $study;
    private $bachelor = 0;
    private $master = 0;

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

    public function bachelor() : int
    {
        return $this->bachelor;
    }

    public function master() : int
    {
        return $this->master;
    }

    public static function fromMultipleStatistics(string $name, ...$others)
    {
        return new self(
            $name,
            collect($others)->reduce(function ($amount, $study) {
                return $amount + $study->bachelor();
            }, 0),
            collect($others)->reduce(function ($amount, $study) {
                return $amount + $study->master();
            }, 0)
        );
    }
}
