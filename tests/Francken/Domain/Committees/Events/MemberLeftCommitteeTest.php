<?php

declare(strict_types=1);

namespace Tests\Francken\Committees\Events;

use Francken\Tests\SetupReconstitution;
use Francken\Domain\Committees\CommitteeId;
use Francken\Domain\Committees\Events\MemberLeftCommittee;
use Francken\Domain\Members\MemberId;

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
