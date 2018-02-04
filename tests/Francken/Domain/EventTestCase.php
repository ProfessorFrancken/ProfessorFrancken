<?php

declare(strict_types=1);

namespace Francken\Tests\Domain;

use Broadway\Serializer\Serializable as SerializableInterface;
use Francken\Tests\SetupReconstitution;
use PHPUnit\Framework\TestCase as TestCase;

abstract class EventTestCase extends TestCase
{
    use SetupReconstitution;

    /** @test */
    public function its_serializable()
    {
        $this->assertInstanceOf(SerializableInterface::class, $this->createInstance());
    }

    /** @test */
    public function serializing_and_hydrating_yields_the_same_object()
    {
        $event = $this->createInstance();
        $this->assertEquals($event, $event::deserialize($event->serialize()));
    }

    /**
     * We don't give a return typehint here so that not all of our tests are
     * forced to include the Broadway\Serializer\Serializable
     * @return SerializableInterface
     */
    abstract protected function createInstance();
}
