<?php

declare(strict_types=1);

namespace Francken\Study\BooksSale\AvailableBooks;

use Broadway\ReadModel\Projector;
use Francken\Study\BooksSale\Events\BookOffered;
use Francken\Study\BooksSale\Events\BookOfferRetracted;
use Francken\Study\BooksSale\Events\BookSaleCancelled;
use Francken\Study\BooksSale\Events\BookSaleCompleted;
use Francken\Study\BooksSale\Events\BookSoldToMember;
use Francken\Study\BooksSale\AvailableBooks\BookDetailsRepository;
use Francken\Study\BooksSale\AvailableBooks\BookTransaction;

final class BookTransactionsProjector extends Projector
{
    private $books;
    private $members;
    private $bookDetailRepository;

    public function __construct(
        Repository $books,
        Repository $members,
        BookDetailsRepository $repo
    ) {
        $this->bookDetailRepository = $repo;
        $this->books = $books;
        $this->members = $members;
    }

    public function whenBookOffered(BookOffered $event) : void
    {
        $bookDetails = $this->bookDetailRepository->getByISBN($event->isbn());

        $seller = $this->members->find((string)$event->selllersId());

        $book = new BookTransaction(
            $event->bookId(),
            $bookDetails->title(),
            $event->sellersId(),
            $seller->fullName(),
            null,
            null,
            $event->price(),
            false,
            false
        );

        $this->books->save($book);
    }

    public function whenBookOfferRetracted(BookOfferRetracted $event) : void
    {
        $this->books->remove($event->bookId());
    }

    public function whenBookSoldToMember(BookSoldToMember $event) : void
    {
        $book = $this->books->find((string)$event->bookId());

        $buyer = $this->members->find((string)$event->buyersId());

        $book = new BookTransaction(
            $book->bookId(),
            $book->title(),
            $book->sellersId(),
            $book->sellersName(),
            $buyer->memberId(),
            $buyer->fullName(),
            $book->price(),
            false,
            false
        );

        $this->books->save($book);
    }

    public function whenBookSaleCancelled(BookSaleCancelled $event) : void
    {
        $book = $this->books->find((string)$event->bookId());

        $book = new BookTransaction(
            $book->bookId(),
            $book->title(),
            $book->sellersId(),
            $book->sellersName(),
            null,
            null,
            $book->price(),
            false,
            false
        );

        $this->books->save($book);
    }

    public function whenBookSaleCompleted(BookSaleCompleted $event) : void
    {
        $book = $this->books->find((string)$event->bookId());

        $book = new BookTransaction(
            $book->bookId(),
            $book->title(),
            $book->sellersId(),
            $book->sellersName(),
            $buyer->memberId(),
            $buyer->fullName(),
            $book->price(),
            true,
            false
        );

        $this->books->save($book);
    }
}
