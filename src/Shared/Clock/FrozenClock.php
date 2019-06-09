<?php

declare(strict_types=1);

namespace Francken\Shared\Clock;

use DateTimeImmutable;

/**
 * Clock frozen in time, useful for testing purposes
 */
final class FrozenClock implements Clock
{
    private $time;

    public function __construct(DateTimeImmutable $time)
    {
        $this->time = $time;
    }

    public function now() : DateTimeImmutable
    {
        return $this->time;
    }
}
