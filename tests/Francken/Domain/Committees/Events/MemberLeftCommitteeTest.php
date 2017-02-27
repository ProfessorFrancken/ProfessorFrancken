<?php

declare(strict_types=1);

namespace Francken\Tests\Committees\Events;

use Francken\Domain\Committees\CommitteeId;
use Francken\Domain\Committees\Events\MemberLeftCommittee;
use Francken\Domain\Members\MemberId;
use Francken\Tests\Domain\EventTestCase as Testcase;

class MemberLeftCommitteeTest extends TestCase
{
    /**
     * @test
     */
    public function it_is_serializable()
    {
        $id = CommitteeId::generate();
        $memberId = MemberId::generate();
        $event = new MemberLeftCommittee($id, $memberId);

        $this->assertEquals(
            $event,
            MemberLeftCommittee::deserialize($event->serialize())
        );

        $this->assertEquals($id, $event->committeeId());
        $this->assertEquals($memberId, $event->memberId());
    }

    protected function createInstance()
    {
        return new MemberLeftCommittee(committeeId::generate(), MemberId::generate());
    }
}
