<?php

namespace Tests\Francken\Activities\Events;

use Tests\SetupReconstitution;

use Francken\Activities\ActivityId;
use Francken\Activities\Events\MemberRegisteredToParticipate;

use Francken\Members\MemberId;

class MemberRegisteredToParticipateTest extends \PHPUnit_Framework_TestCase
{
    use SetupReconstitution;

    /**
     * @test
     */
    public function it_happend_to_an_activity()
    {
        $id = ActivityId::generate();
        $memberId = MemberId::generate();

        $event = new MemberRegisteredToParticipate($id, $memberId);

        $this->assertEquals($id, $event->activityId());
        $this->assertEquals($memberId, $event->memberId());
    }

    /**
     * @test
     */
    public function it_is_serializable()
    {
        $id = ActivityId::generate();
        $memberId = MemberId::generate();

        $event = new MemberRegisteredToParticipate($id, $memberId);

        $this->assertEquals(
            $event,
            MemberRegisteredToParticipate::deserialize($event->serialize())
        );
    }
}