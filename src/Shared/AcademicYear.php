<?php

declare(strict_types=1);

namespace Francken\Shared;

use DateTimeImmutable;
use League\Period\Period;

final class AcademicYear
{
    private $period;

    private function __construct(Period $period)
    {
        $this->period = $period;
    }

    public function contains(DateTimeImmutable $time) : bool
    {
        return $this->period->contains($time);
    }

    /**
     * Assume that $years is of the form yyyy-yyyy and get the start and end year
     * from it. Moreover assume that a board year starts and ends at the end of August
     */
    public static function fromString(string $years) : self
    {
        preg_match('/(\d{4})-(\d{4})/', $years, $matches);

        $start = new DateTimeImmutable('01-08-' . $matches[1]);
        $end = new DateTimeImmutable('01-07-' . $matches[2]);

        return new self(new Period($start, $end));
    }


    /**
     * Returns the academic year that is associated to the date
     */
    public static function fromDate(DateTimeImmutable $date) : self
    {
        $year = (int)$date->format('Y');

        //
        if ($date < new DateTimeImmutable(sprintf('01-07-%s', $year))) {
            return self::fromString(sprintf(
                '%d-%d', $year - 1, $year
            ));
        }
        return self::fromString(sprintf(
            '%d-%d', $year, $year + 1
        ));
    }

    public function nextYear() : self
    {
        return self::fromString(
            sprintf(
                '%d-%d',
                ((int)$this->period->getStartDate()->format('Y') + 1),
                ((int)$this->period->getEndDate()->format('Y') + 1)
            )
        );
    }

    public function previousYear() : self
    {
        return self::fromString(
            sprintf(
                '%d-%d',
                ((int)$this->period->getStartDate()->format('Y') - 1),
                ((int)$this->period->getEndDate()->format('Y') - 1)
            )
        );
    }

    public function toString() : string
    {
        return sprintf(
            '%s - %s',
            $this->period->getStartDate()->format('Y'),
            $this->period->getEndDate()->format('Y')
        );
    }

    public function start() : DateTimeImmutable
    {
        return $this->period->getStartDate();
    }

    public function end() : DateTimeImmutable
    {
        return $this->period->getEndDate();
    }
}
