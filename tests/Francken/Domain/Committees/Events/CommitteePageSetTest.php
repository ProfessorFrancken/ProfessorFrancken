<?php

declare(strict_types=1);

namespace Francken\Tests\Domain\Committees\Events;

use Francken\Domain\Committees\CommitteeId;
use Francken\Domain\Committees\Events\CommitteePageSet;
use Francken\Domain\Members\MemberId;
use Francken\Tests\Domain\EventTestCase as Testcase;

class CommitteePageSetTest extends TestCase
{
    /**
     * @test
     */
    public function it_holds_a_markdown_string()
    {
        $id = CommitteeId::generate();
        $event = new CommitteePageSet($id, '# Title\nPlain text');

        $this->assertEquals($id, $event->committeeId());
        $this->assertEquals('# Title\nPlain text', $event->page());
    }

    protected function createInstance()
    {
        return new CommitteePageSet(CommitteeId::generate(), '# Title\nPlain text');
    }
}
