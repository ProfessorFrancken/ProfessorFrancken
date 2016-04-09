<?php

namespace Tests\Francken\Committees\Events;

use Tests\SetupReconstitution;
use Francken\Committees\CommitteeId;
use Francken\Committees\Events\CommitteeInstantiated;

class CommitteeInstantiatedTest extends \PHPUnit_Framework_TestCase
{
    use SetupReconstitution;

    /**
     * @test
     */
    public function it_is_serializable()
    {
        $id = CommitteeId::generate();
        $event = new CommitteeInstantiated($id, 'name', 'goal');

        $this->assertEquals(
            $event,
            CommitteeInstantiated::deserialize($event->serialize())
        );
    }
}
