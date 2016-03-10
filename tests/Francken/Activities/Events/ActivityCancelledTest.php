<?php

namespace Tests\Francken\Activities\Events;

use Tests\SetupReconstitution;

use Francken\Activities\ActivityId;
use Francken\Activities\Events\ActivityCancelled;

class ActivityCancelledTest extends \PHPUnit_Framework_TestCase
{
    use SetupReconstitution;

    /**
     * @test
     */
    public function it_happend_to_an_activity()
    {
        $id = ActivityId::generate();
        $event = new ActivityCancelled($id);

        $this->assertEquals($id, $event->activityId());
    }

    /**
     * @test
     */
    public function it_is_serializable()
    {
        $id = ActivityId::generate();
        $event = new ActivityCancelled($id);

        $this->assertEquals(
            $event,
            ActivityCancelled::deserialize($event->serialize())
        );
    }
}
