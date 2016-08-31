<?php

declare(strict_types=1);

namespace Tests\Francken\Committees\Events;

use Francken\Tests\SetupReconstitution;
use Francken\Domain\Committees\CommitteeId;
use Francken\Domain\Committees\Events\CommitteeGoalChanged;
use Francken\Domain\Members\MemberId;

class CommitteeGoalChangedTest extends \PHPUnit_Framework_TestCase
{
    use SetupReconstitution;

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
}
