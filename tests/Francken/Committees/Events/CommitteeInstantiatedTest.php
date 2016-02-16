<?php

namespace Tests\Francken\Committees\Events;

use Tests\SetupReconstitution;

use Broadway\EventSourcing\Testing\AggregateRootScenarioTestCase;
use Broadway\UuidGenerator\Rfc4122\Version4Generator;

use Francken\Committees\Committee;
use Francken\Committees\CommitteeId;
use Francken\Committees\Events\CommitteeInstantiated;

class CommitteeInstantiatedTest extends \PHPUnit_Framework_TestCase
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
        $id = new CommitteeId($this->generator->generate());
        $event = new CommitteeInstantiated($id, 'name', 'goal');

        $this->assertEquals(
            $event,
            CommitteeInstantiated::deserialize($event->serialize())
        );
    }
}