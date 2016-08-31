<?php

declare(strict_types=1);

namespace Tests\Francken\Committees\Events;

use Francken\Tests\SetupReconstitution;
use Francken\Domain\Committees\CommitteeId;
use Francken\Domain\Committees\Events\MemberJoinedCommittee;
use Francken\Domain\Members\MemberId;

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
