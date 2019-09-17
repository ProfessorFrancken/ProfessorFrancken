<?php

declare(strict_types=1);

namespace Francken\Tests\Domain\Committees\Events;

use Francken\Domain\Committees\CommitteeId;
use Francken\Domain\Committees\Events\CommitteePageChanged;
use Francken\Tests\Domain\EventTestCase as Testcase;

class CommitteePageChangedTest extends TestCase
{
    /**
     * @test
     */
    public function it_holds_a_markdown_string() : void
    {
        $id = CommitteeId::generate();
        $event = new CommitteePageChanged($id, '# Title\nPlain text');

        $this->assertEquals($id, $event->committeeId());
        $this->assertEquals('# Title\nPlain text', $event->page());
    }

    protected function createInstance()
    {
        return new CommitteePageChanged(CommitteeId::generate(), '# Title\nPlain text');
    }
}
