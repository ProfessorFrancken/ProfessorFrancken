<?php

declare(strict_types=1);

namespace Tests\Francken\Committees\Events;

use Francken\Domain\Committees\CommitteeId;
use Francken\Domain\Committees\Events\MemberJoinedCommittee;
use Francken\Domain\Members\MemberId;
use Francken\Tests\Domain\EventTestCase as Testcase;

class MemberJoinedCommitteeTest extends TestCase
{
    /**
     * @test
     */
    public function it_is_serializable() : void
    {
        $id = CommitteeId::generate();
        $memberId = MemberId::generate();
        $event = new MemberJoinedCommittee($id, $memberId);

        $this->assertEquals(
            $event,
            MemberJoinedCommittee::deserialize($event->serialize())
        );

        $this->assertEquals($id, $event->committeeId());
        $this->assertEquals($memberId, $event->memberId());
    }

    protected function createInstance()
    {
        return new MemberJoinedCommittee(committeeId::generate(), MemberId::generate());
    }
}
