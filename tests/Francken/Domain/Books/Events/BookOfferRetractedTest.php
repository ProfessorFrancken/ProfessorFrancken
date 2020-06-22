<?php

declare(strict_types=1);

namespace Tests\Francken\Books\Events;

use Francken\Study\BooksSale\BookId;
use Francken\Study\BooksSale\Events\BookOfferRetracted;
use Francken\Tests\Domain\EventTestCase as Testcase;

class BookOfferRetractedTest extends Testcase
{
    /** @test */
    public function an_event_holds_data() : void
    {
        $bookId = BookId::generate();

        $event = new BookOfferRetracted($bookId);

        $this->assertEquals($event->bookId(), $bookId);
    }

    protected function createInstance()
    {
        $bookId = BookId::generate();

        return new BookOfferRetracted($bookId);
    }
}
