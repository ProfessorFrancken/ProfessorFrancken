<?php

declare(strict_types=1);

namespace Francken\Extern\FactSheet;

interface StudyStatistic
{
    public function study() : string;

    /*
     * Used to create "Total" and "Other" statistics
     */
    public static function fromMultipleStatistics(string $name, ...$others);
}
