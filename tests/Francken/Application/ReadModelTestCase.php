<?php

declare(strict_types=1);

namespace Francken\Tests\Application;

use Broadway\Serializer\Serializable;
use Francken\Tests\SetupReconstitution;
use PHPUnit\Framework\TestCase as TestCase;

abstract class ReadModelTestCase extends TestCase
{
    use SetupReconstitution;

    /** @test */
    public function its_serializable()
    {
        $this->assertInstanceOf(Serializable::class, $this->createInstance());
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
