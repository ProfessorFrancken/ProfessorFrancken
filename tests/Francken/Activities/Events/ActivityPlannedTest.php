<?php

namespace Tests\Francken\Activities\Events;

use Tests\SetupReconstitution;

use Broadway\UuidGenerator\Rfc4122\Version4Generator;

use Francken\Activities\ActivityId;
use Francken\Activities\Activity;
use Francken\Activities\Location;
use Francken\Activities\Events\ActivityPlanned;

use DateTime;

class ActivityPlannedTest extends \PHPUnit_Framework_TestCase
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
    public function it_is_serializable()
    {
        $id = new ActivityId($this->generator->generate());
        $event = new ActivityPlanned(
            $id,
            'Crash & Compile',
            'Programming competition',
            new DateTime('2015-12-04'),
            Location::fromNameAndAddress('Francken kamer'),
            Activity::SOCIAL
        );

        $this->assertEquals(
            $event,
            ActivityPlanned::deserialize($event->serialize())
        );
    }
}