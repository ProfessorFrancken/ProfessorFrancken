<?php

declare(strict_types=1);

namespace Tests\Francken\Books;

use Francken\Tests\Domain\EventTestCase as Testcase;

use Francken\Domain\Members\MemberId;
use Francken\Domain\Books\BookId;

use Francken\Domain\Books\Events\BookOffered;

class BookEventTest extends Testcase
{

    /** @test */
    public function an_event_holds_data()
    {
        $bookId = BookId::generate();
        $sellersId = MemberId::generate();
        $isbn = "0534408133";

        $event = new BookOffered($bookId, $sellersId, $isbn, 1500);

        $this->assertEquals($event->bookId(), $bookId);
        $this->assertEquals($event->sellersId(), $sellersId);
        $this->assertEquals($event->isbn(), $isbn);
        $this->assertEquals($event->price(), 1500);
    }

    protected function createInstance()
    {
        $bookId = BookId::generate();
        $sellersId = MemberId::generate();

        return new BookOffered($bookId, $sellersId, "0534408133", 1500);
    }
}
