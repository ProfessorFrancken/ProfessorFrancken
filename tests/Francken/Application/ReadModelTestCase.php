<?php

declare(strict_types=1);

namespace Francken\Tests\Application;

use Broadway\Serializer\SerializableInterface;
use Francken\Tests\SetupReconstitution;
use PHPUnit_Framework_TestCase as TestCase;

abstract class ReadModelTestCase extends TestCase
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
     * forced to include the Broadway\Serializer\SerializableInterface
     * @return SerializableInterface
     */
    abstract protected function createInstance();
}
