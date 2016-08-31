<?php

declare(strict_types=1);

namespace Tests\Francken\Committees\Events;

use Francken\Domain\Committees\CommitteeId;
use Francken\Domain\Committees\Events\CommitteeInstantiated;
use Francken\Tests\Domain\EventTestCase as Testcase;

class CommitteeInstantiatedTest extends TestCase
{
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

    protected function createInstance()
    {
        return new CommitteeInstantiated(CommitteeId::generate(), 'name', 'goal');
    }
}
