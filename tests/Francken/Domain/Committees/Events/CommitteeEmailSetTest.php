<?php

declare(strict_types=1);

namespace Francken\Tests\Domain\Committees\Events;

use Francken\Domain\Committees\CommitteeId;
use Francken\Domain\Committees\Events\CommitteeEmailSet;
use Francken\Domain\Members\Email;
use Francken\Tests\Domain\EventTestCase as Testcase;

class CommitteeEmailSetTest extends TestCase
{
    /**
     * @test
     */
    public function it_holds_an_email_adress()
    {
        $id = CommitteeId::generate();
        $event = new CommitteeEmailSet($id, new Email("scriptcie@professorfrancken.nl"));

        $this->assertEquals($id, $event->committeeId());
        $this->assertEquals(new Email("scriptcie@professorfrancken.nl"), $event->email());
    }

    /**
     * @test
     */
    public function it_an_email_can_be_empty()
    {
        $id = CommitteeId::generate();
        $event = new CommitteeEmailSet($id, null);

        $this->assertEquals($id, $event->committeeId());
        $this->assertEquals(null, $event->email());
    }

    protected function createInstance()
    {
        return new CommitteeEmailSet(CommitteeId::generate(), new Email("scriptcie@professorfrancken.nl"));
    }
}
