<?php

namespace Tests\Francken\Committees\Events;

use Tests\SetupReconstitution;
use Francken\Committees\CommitteeId;
use Francken\Committees\Events\MemberLeftCommittee;
use Francken\Members\MemberId;

class MemberLeftCommitteeTest extends \PHPUnit_Framework_TestCase
{
    use SetupReconstitution;

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
}
