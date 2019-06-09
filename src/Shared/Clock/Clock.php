<?php

declare(strict_types=1);

namespace Francken\Shared\Clock;

use DateTimeImmutable;

/**
 * @see https://blog.frankdejonge.nl/being-in-control-of-time-in-php/
 */
interface Clock
{
    public function now() : DateTimeImmutable;
}
