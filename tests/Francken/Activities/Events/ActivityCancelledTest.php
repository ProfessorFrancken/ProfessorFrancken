<?php

namespace Tests\Francken\Activities\Events;

use Tests\SetupReconstitution;

use Broadway\UuidGenerator\Rfc4122\Version4Generator;

use Francken\Activities\ActivityId;
use Francken\Activities\Events\ActivityCancelled;

class ActivityCancelledTest extends \PHPUnit_Framework_TestCase
{
    use SetupReconstitution;

    private $generator;

    public function setUp()
    {
        parent::setUp();

        $this->generator = new Version4Generator();
    }

    /**
     * @test
     */
    public function it_happend_to_an_activity()
    {
        $id = new ActivityId($this->generator->generate());
        $event = new ActivityCancelled($id);

        $this->assertEquals($id, $event->activityId());
    }

    /**
     * @test
     */
    public function it_is_serializable()
    {
        $id = new ActivityId($this->generator->generate());
        $event = new ActivityCancelled($id);

        $this->assertEquals(
            $event,
            ActivityCancelled::deserialize($event->serialize())
        );
    }
}
