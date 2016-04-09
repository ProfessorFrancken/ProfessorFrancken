<?php

namespace Tests\Francken\Committees\Events;

use Tests\SetupReconstitution;
use Francken\Committees\CommitteeId;
use Francken\Committees\Events\MemberJoinedCommittee;
use Francken\Members\MemberId;

class MemberJoinedCommitteeTest extends \PHPUnit_Framework_TestCase
{
    use SetupReconstitution;

    /**
     * @test
     */
    public function it_is_serializable()
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
}
