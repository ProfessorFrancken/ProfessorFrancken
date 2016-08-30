<?php

declare(strict_types=1);

namespace Tests\Francken\Committees\Events;

use Tests\SetupReconstitution;
use Francken\Domain\Committees\CommitteeId;
use Francken\Domain\Committees\Events\CommitteeNameChanged;

class CommitteeNameChangedTest extends \PHPUnit_Framework_TestCase
{
    use SetupReconstitution;

    /**
     * @test
     */
    public function it_is_serializable()
    {
        $id = CommitteeId::generate();
        $event = new CommitteeNameChanged($id, 'S[ck]rip(t|t?c)ie 2');

        $this->assertEquals(
            $event,
            CommitteeNameChanged::deserialize($event->serialize())
        );

        $this->assertEquals($id, $event->committeeId());
        $this->assertEquals('S[ck]rip(t|t?c)ie 2', $event->name());
    }
}
