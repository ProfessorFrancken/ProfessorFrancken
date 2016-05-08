<?php

namespace Tests\Francken\Books;

use Francken\Domain\Members\MemberId;
use Francken\Domain\Books\BookId;

use Francken\Domain\Books\Events\BookWasOffered;
use Francken\Domain\Books\Events\BookOfferRetracted;
use Francken\Domain\Books\Events\BookSaleCancelled;
use Francken\Domain\Books\Events\BookSoldToMember;
use Francken\Domain\Books\Events\BookSoldToNonMember;

class BookEventTest extends \PHPUnit_Framework_TestCase
{

    /** @test */
    public function an_event_holds_data()
    {
        $bookId = BookId::generate();
        $sellersId = MemberId::generate();
        $isbn = ISBN::fromString("0534408133");

        $event = new BookWasOffered($bookId, $sellersId, $isbn, 1500);

        $this->assertEquals($id, $event->bookId());
    }

    /** @test */
    public function it_is_serializable()
    {
        $bookId = BookId::generate();
        $sellersId = MemberId::generate();
        $isbn = ISBN::fromString("0534408133");

        $event = new BookWasOffered($bookId, $sellersId, $isbn, 1500);

        $this->assertEquals(
            $event,
            BookWasOffered::deserialize($event->serialize())
        );
    }
}
