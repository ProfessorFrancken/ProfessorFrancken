<?php

declare(strict_types=1);

namespace Francken\Application\Books;

use Broadway\ReadModel\Projector;
use Francken\Domain\Books\Events\BookOffered;
use Francken\Domain\Books\Events\BookOfferRetracted;
use Francken\Domain\Books\Events\BookSaleCancelled;
use Francken\Domain\Books\Events\BookSaleCompleted;
use Francken\Domain\Books\Events\BookSoldToMember;

final class BookTransactionsProjector extends Projector
{
    private $books;
    private $members;
    private $bookDetailRepository;

    public function __construct(Repository $books, Repository $members, BookDetailsRepositoryI $repo)
    {
        $this->bookDetailRepository = $repo;
        $this->books = $books;
    }

    public function whenBookOffered(BookOffered $event)
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

    public function whenBookOfferRetracted(BookOfferRetracted $event)
    {
        $this->books->remove($event->bookId());
    }

    public function whenBookSoldToMember(BookSoldToMember $event)
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

    public function whenBookSaleCancelled(BookSaleCancelled $event)
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

    public function whenBookSaleCompleted(BookSaleCompleted $event)
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
