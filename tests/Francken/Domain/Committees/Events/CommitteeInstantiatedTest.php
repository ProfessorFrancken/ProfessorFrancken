<?php

declare(strict_types=1);

namespace Tests\Francken\Committees\Events;

use Francken\Tests\SetupReconstitution;
use Francken\Domain\Committees\CommitteeId;
use Francken\Domain\Committees\Events\CommitteeInstantiated;

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
