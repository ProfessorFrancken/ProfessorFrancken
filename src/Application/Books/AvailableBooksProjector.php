<?php

declare(strict_types=1);

namespace Francken\Application\Books;

use Francken\Application\Projector;
use Francken\Domain\Books\Events\BookOffered;
use Francken\Domain\Books\Events\BookOfferRetracted;
use Francken\Domain\Books\Events\BookSaleCancelled;
use Francken\Domain\Books\Events\BookSaleCompleted;
use Francken\Domain\Books\Events\BookSoldToMember;

final class AvailableBooksProjector extends Projector
{
    private $books;
    private $bookDetailRepository;

    public function __construct(AvailableBooksRepository $books, BookDetailsRepository $repo)
    {
        $this->bookDetailRepository = $repo;
        $this->books = $books;
    }

    public function whenBookOffered(BookOffered $event) : void
    {
        $bookDetails = $this->bookDetailRepository->getByISBN($event->isbn());

        $book = new AvailableBook(
            $event->bookId(),
            $bookDetails->title(),
            $bookDetails->author(),
            $event->price(),
            $event->isbn(),
            $bookDetails->pathToCover(),
            false
        ); //salePending

        $this->books->save($book);
    }

    public function whenBookOfferRetracted(BookOfferRetracted $event) : void
    {
        $this->books->remove($event->bookId());
    }

    public function whenBookSoldToMember(BookSoldToMember $event) : void
    {
        $book = $this->books->find($event->bookId());

        $book = new AvailableBook(
            $book->bookId(),
            $book->title(),
            $book->author(),
            $book->price(),
            $book->isbn(),
            $book->pathToCover(),
            true
        );

        $this->books->save($book);
    }

    public function whenBookSaleCancelled(BookSaleCancelled $event) : void
    {
        $book = $this->books->find($event->bookId());

        $book = new AvailableBook(
            $book->bookId(),
            $book->title(),
            $book->author(),
            $book->price(),
            $book->isbn(),
            $book->pathToCover(),
            false
        );

        $this->books->save($book);
    }

    public function whenBookSaleCompleted(BookSaleCompleted $event) : void
    {
        $this->books->remove($event->bookId());
    }
}
