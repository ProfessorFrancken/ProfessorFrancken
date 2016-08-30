<?php

declare(strict_types=1);

namespace Francken\Domain\Activities;

use DateTimeImmutable as DateTime;
use InvalidArgumentException;

final class Schedule
{
    private $startTime;
    private $endTime;

    private function __construct(DateTime $startTime, DateTime $endTime = null)
    {
        $this->startTime = $startTime;
        $this->endTime = $endTime;
    }

    public static function withStartTime(DateTime $startTime) : Schedule
    {
        return new Schedule($startTime);
    }

    public static function forPeriod(DateTime $startTime, DateTime $endTime) : Schedule
    {
        if ($startTime >= $endTime) {
            throw new InvalidArgumentException("A schedule's end time can't be before the start time");
        }

        return new Schedule($startTime, $endTime);
    }

    public function startTime() : DateTime
    {
        return $this->startTime;
    }

    /**
     * Either returns the given end time, or null if it was not specified
     * @return DateTimeImmutable|null
     */
    public function endTime()
    {
        return $this->endTime;
    }
}
