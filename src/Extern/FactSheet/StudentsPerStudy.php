<?php

declare(strict_types=1);

namespace Francken\Extern\FactSheet;

final class StudentsPerStudy implements StudyStatistic
{
    private string $study;
    private int $amount;

    public function __construct(string $study, int $amount)
    {
        $this->study = $study;
        $this->amount = $amount;
    }

    public function study() : string
    {
        return $this->study;
    }

    public function amount() : int
    {
        return $this->amount;
    }

    /*
     * Used to create "Total" and "Other" statistics
     */
    public static function fromMultipleStatistics(string $name, StudyStatistic ...$others) : StudyStatistic
    {
        return new self(
            $name,
            collect($others)->reduce(
                fn (int $amount, StudyStatistic $study) : int => $amount + $study->amount(),
                0
            )
        );
    }
}
