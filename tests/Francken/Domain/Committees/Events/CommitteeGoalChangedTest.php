<?php

declare(strict_types=1);

namespace Francken\Tests\Domain\Committees\Events;

use Francken\Domain\Committees\CommitteeId;
use Francken\Domain\Committees\Events\CommitteeGoalChanged;
use Francken\Domain\Members\MemberId;
use Francken\Tests\Domain\EventTestCase as Testcase;

class CommitteeGoalChangedTest extends TestCase
{
    /**
     * @test
     */
    public function it_is_serializable()
    {
        $id = CommitteeId::generate();
        $event = new CommitteeGoalChanged($id, 'Websites bouwen');

        $this->assertEquals(
            $event,
            CommitteeGoalChanged::deserialize($event->serialize())
        );

        $this->assertEquals($id, $event->committeeId());
        $this->assertEquals('Websites bouwen', $event->goal());
    }

    protected function createInstance()
    {
        return new CommitteeGoalChanged(CommitteeId::generate(), 'Websites bouwen');
    }
}
