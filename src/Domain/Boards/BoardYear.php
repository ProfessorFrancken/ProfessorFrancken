<?php

declare(strict_types=1);

namespace Francken\Domain\Boards;

use League\Period\Period;
use DateTimeImmutable;

final class BoardYear
{
    private $period;

    private function __construct(Period $period)
    {
        $this->period = $period;
    }

    public static function from(DateTimeImmutable $start, DateTimeImmutable $end) : self
    {
        return new BoardYear(new Period($start, $end));
    }

    public function contains(DateTimeImmutable $time) : bool
    {
        return $this->period->contains($time);
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
