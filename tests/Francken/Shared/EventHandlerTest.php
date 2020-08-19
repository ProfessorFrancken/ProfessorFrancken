<?php

declare(strict_types=1);

namespace Francken\Tests\Shared;

use Francken\Shared\EventHandler;
use PHPUnit\Framework\TestCase;

class EventHandlerTest extends TestCase
{
    /** @test */
    public function it_handles_events() : void
    {
        $handler = new FakeEventHandler();
        $handler->handle(new FakeEvent());
        $this->assertTrue($handler->wasCalled);
    }

    /** @test */
    public function it_ignores_unhandled_events() : void
    {
        $handler = new FakeEventHandler();
        $handler->handle(new AnotherFakeEvent());
        $this->assertFalse($handler->wasCalled);
    }
}

final class FakeEvent
{
}

final class AnotherFakeEvent
{
}

final class FakeEventHandler extends EventHandler
{
    public bool $wasCalled = false;
    public function whenFakeEvent(FakeEvent $event) : void
    {
        $this->wasCalled = true;
    }
}
