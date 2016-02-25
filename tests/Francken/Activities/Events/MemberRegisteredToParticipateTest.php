<?php

namespace Tests\Francken\Activities\Events;

use Tests\SetupReconstitution;

use Broadway\UuidGenerator\Rfc4122\Version4Generator;

use Francken\Activities\ActivityId;
use Francken\Activities\Events\MemberRegisteredToParticipate;

use Francken\Members\MemberId;

class MemberRegisteredToParticipateTest extends \PHPUnit_Framework_TestCase
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
        $memberId = new MemberId($this->generator->generate());

        $event = new MemberRegisteredToParticipate($id, $memberId);

        $this->assertEquals($id, $event->activityId());
        $this->assertEquals($memberId, $event->memberId());
    }

    /**
     * @test
     */
    public function it_is_serializable()
    {
        $id = new ActivityId($this->generator->generate());
        $memberId = new MemberId($this->generator->generate());

        $event = new MemberRegisteredToParticipate($id, $memberId);

        $this->assertEquals(
            $event,
            MemberRegisteredToParticipate::deserialize($event->serialize())
        );
    }
}