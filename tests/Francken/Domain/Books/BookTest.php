<?php

namespace Tests\Francken\Books;

use Broadway\EventSourcing\Testing\AggregateRootScenarioTestCase;
use Francken\Domain\Books\Book;
use Francken\Domain\Books\BookId;
use Francken\Domain\Books\Events\BookOffered;
use Francken\Domain\Books\Events\BookSaleCancelled;
use Francken\Domain\Books\Events\BookSoldToMember;
use Francken\Domain\Books\Events\BookSoldToNonMember;

use Francken\Domain\Members\MemberId;

class BookTest extends AggregateRootScenarioTestCase
{
    protected function getAggregateRootClass()
    {
        return Book::class;
    }

    /** @test */
    public function a_book_can_be_offered()
    {
        $bookId = BookId::generate();
        $memberId = MemberId::generate();

        $this->scenario
            ->when(function () use ($bookId, $memberId) {
                return Book::offer(
                    $bookId,
                    $memberId,
                    "0534408133",
                    1500 //= 15 euro
                );
            })
            ->then([
                new BookOffered(
                    $bookId,
                    $memberId,
                    "0534408133",
                    1500 //= 15 euro
                )
            ]);
    }

    /** @test */
    public function a_book_can_be_sold_to_a_member()
    {
        $bookId = BookId::generate();
        $memberId = MemberId::generate();
        $buyersId = MemberId::generate();

        $this->scenario
            ->withAggregateId($bookId)
            ->given([
                new BookOffered(
                    $bookId,
                    $memberId,
                    "0534408133",
                    1500)
                ])
            ->when(function ($book) use ($buyersId) {
                    return $book->sellToMember($buyersId);
                })
            ->then([new BookSoldToMember($bookId, $buyersId)]);
    }

    /**
    * @test
    */
    public function a_book_cannot_be_sold_twice()
    {
        $bookId = BookId::generate();
        $memberId = MemberId::generate();
        $buyersId1 = MemberId::generate();
        $buyersId2 = MemberId::generate();

        $book = Book::offer(
                    $bookId,
                    $memberId,
                    "0534408133",
                    1500); //15 euro

        $book->sellToMember($buyersId1);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("A book cannot be sold twice");
        $book->sellToMember($buyersId2);
    }

    public function given_an_offered_book(BookId $bookId, MemberId $memberId)
    {

        return $this->scenario
            ->withAggregateId($bookId)
            ->given([
                new BookOffered(
                    $bookId,
                    $memberId,
                    "0534408133",
                    1500)
                ]);
    }
}
