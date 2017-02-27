<?php

declare(strict_types=1);

namespace Francken\Domain\Activities;

use Broadway\Serializer\SerializableInterface;
use DateTimeImmutable as DateTime;
use InvalidArgumentException;

final class Schedule implements SerializableInterface
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
        return new self($startTime);
    }

    public static function forPeriod(DateTime $startTime, DateTime $endTime) : Schedule
    {
        if ($startTime >= $endTime) {
            throw new InvalidArgumentException("A schedule's end time can't be before the start time");
        }

        return new self($startTime, $endTime);
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

    public function serialize()
    {
        return [
            'startTime' => $this->startTime->format(\DateTime::ISO8601),
            'endTime' => is_null($this->endTime) ? null : $this->endTime->format(\DateTime::ISO8601)
        ];
    }

    public static function deserialize(array $schedule)
    {
        return new self(
            DateTime::createFromFormat(\DateTime::ISO8601, $schedule['startTime']),
            is_null($schedule['endTime']) ? null : DateTime::createFromFormat(\DateTime::ISO8601, $schedule['endTime'])
        );
    }
}
