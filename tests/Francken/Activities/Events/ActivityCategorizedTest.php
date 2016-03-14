<?php

namespace Tests\Francken\Activities\Events;

use Tests\SetupReconstitution;
use Francken\Activities\ActivityId;
use Francken\Activities\Activity;
use Francken\Activities\Events\ActivityCategorized;

class ActivityCategorizedTest extends \PHPUnit_Framework_TestCase
{
    use SetupReconstitution;

    /**
     * @test
     */
    public function it_happend_to_an_activity()
    {
        $id = ActivityId::generate();
        $event = new ActivityCategorized($id, Activity::SOCIAL);

        $this->assertEquals($id, $event->activityId());
        $this->assertEquals(Activity::SOCIAL, $event->category());
    }

    /**
     * @test
     */
    public function it_is_serializable()
    {
        $id = ActivityId::generate();
        $event = new ActivityCategorized($id, Activity::EDUCATION);

        $this->assertEquals(
            $event,
            ActivityCategorized::deserialize($event->serialize())
        );
    }
}
