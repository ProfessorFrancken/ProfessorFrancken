<?php

declare(strict_types=1);

namespace Francken\Tests\Activities\Events;

use Francken\Domain\Activities\ActivityId;
use Francken\Domain\Activities\Events\MemberRegisteredToParticipate;
use Francken\Domain\Members\MemberId;
use Francken\Tests\Domain\EventTestCase as Testcase;

class MemberRegisteredToParticipateTest extends TestCase
{
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

    protected function createInstance()
    {
        return new MemberRegisteredToParticipate(ActivityId::generate(), MemberId::generate());
    }
}
