<?php

declare(strict_types=1);

namespace Francken\Extern\FactSheet;

interface StudyStatistic
{
    public function study() : string;

    public function amount() : int;

    /*
     * Used to create "Total" and "Other" statistics
     */
    public static function fromMultipleStatistics(string $name, self ...$others) : self;
}
