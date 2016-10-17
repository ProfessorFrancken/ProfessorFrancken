<?php

namespace Francken\Domain\Books;

use Broadway\EventSourcing\EventSourcedAggregateRoot;

use Francken\Domain\Books\BookId;
use Francken\Domain\Books\Guest;
use Francken\Domain\Books\Events\BookOffered;
use Francken\Domain\Books\Events\BookOfferRetracted;
use Francken\Domain\Books\Events\BookSaleCancelled;
use Francken\Domain\Books\Events\BookSoldToMember;
use Francken\Domain\Books\Events\BookSoldToNonMember;
use Francken\Domain\Members\MemberId;

final class Book extends EventSourcedAggregateRoot
{
    private $id;
    private $sellersId;
    private $isbn_10;
    private $price;
    private $isSold = false;
    private $isPaid = false;

    public static function offer(BookId $id, MemberId $sellersId, string $isbn, int $price) : Book
    {
        $book = new Book;
        $book->apply(new BookOffered($id, $sellersId, $isbn, $price));
        return $book;
    }

    public function offerRetracted()
    {
        $this->apply(new BookOfferRetracted($id));
    }

    public function sellToMember(MemberId $memberId)
    {
        if ($this->isSold) {
            throw new \Exception("A book cannot be sold twice");
        }
        $this->isSold = true;
        $this->apply(new BookSoldToMember($this->id, $memberId));
    }

    public function sellToNonMember(Guest $guest)
    {
        if ($this->isSold) {
            throw new \Exception("A book cannot be sold twice");
        }
        $this->isSold = true;
        $this->apply(new BookSoldToNonMember($this->id, $guest));
    }

    public function cancelSale()
    {
        $this->apply(new BookSaleCancelled($this->id));
    }

    public function completeSale()
    {
        $this->apply(new BookSaleCompleted($this->id));
    }

    public function completePayment()
    {
        $this->apply(new BookPayedFor($this->id));
    }

    public function applyBookOffered(BookOffered $event)
    {
        $this->id = $event->bookId();
        $this->sellersId = $event->sellersId();
        $this->isbn_10 = $event->isbn();
        $this->price = $event->price();
    }

    public function applyBookSoldToMember(BookSoldToMember $event)
    {
        // ///@todo Mail bestuah?
        // if($this->isSold)
        //     throw new \Exception("A book cannot be sold twice");
        $this->isSold = true;
    }

    public function applyBookSoldToNonMember(BookSoldToNonMember $event)
    {
        // ///@todo Mail bestuah?
        // if($this->isSold)
        //     throw new \Exception("A book cannot be sold twice");
        $this->isSold = true;
    }

    public function applyBookSaleCancelled(BookSaleCancelled $event)
    {
        $this->isSold = false;
    }

    public function getAggregateRootId()
    {
        return $this->id;
    }
}
