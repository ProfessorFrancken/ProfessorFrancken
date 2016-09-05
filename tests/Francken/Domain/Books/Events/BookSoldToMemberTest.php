<?php

declare(strict_types=1);

namespace Tests\Francken\Books;

use Francken\Tests\Domain\EventTestCase as Testcase;
use Francken\Domain\Members\MemberId;
use Francken\Domain\Books\BookId;
use Francken\Domain\Books\Events\BookSoldToMember;

class BookEventTest extends Testcase
{
    /** @test */
    public function an_event_holds_data()
    {
        $bookId = BookId::generate();
        $buyersId = MemberId::generate();

        $event = new BookSoldToMember($bookId, $buyersId);

        $this->assertEquals($event->bookId(), $bookId);
        $this->assertEquals($event->buyersId(), $buyersId);
    }

    protected function createInstance()
    {
        $bookId = BookId::generate();
        $buyersId = MemberId::generate();

        return new BookSoldToMember($bookId, $buyersId);
    }
}
