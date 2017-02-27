<?php

declare(strict_types=1);

namespace Francken\Tests\Committees\Events;

use Francken\Domain\Committees\CommitteeId;
use Francken\Domain\Committees\Events\CommitteeNameChanged;
use Francken\Tests\Domain\EventTestCase as Testcase;

class CommitteeNameChangedTest extends TestCase
{
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

    protected function createInstance()
    {
        return new CommitteeNameChanged(CommitteeId::generate(), 'S[ck]rip(t|t?c)ie 2');
    }
}
