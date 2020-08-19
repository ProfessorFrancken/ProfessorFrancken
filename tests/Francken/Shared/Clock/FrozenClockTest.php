<?php

declare(strict_types=1);

namespace Francken\Tests\Shared\Clock;

use DateTimeImmutable;
use Francken\Shared\Clock\FrozenClock;
use PHPUnit\Framework\TestCase;

class FrozenClockTest extends TestCase
{
    /** @test */
    public function it_freezes_time() : void
    {
        $now = new DateTimeImmutable();
        $clock = new FrozenClock($now);

        $this->assertEquals($now, $clock->now());
    }
}
