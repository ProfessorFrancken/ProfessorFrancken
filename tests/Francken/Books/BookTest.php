<?php

namespace Tests\Francken\Domain\Books;

use Broadway\EventSourcing\Testing\AggregateRootScenarioTestCase;
use Francken\Domain\Books\Book;
use Francken\Domain\Books\BookId;
use Francken\Domain\Books\ISBN;
use Francken\Domain\Books\Events\BookWasOffered;

use Francken\Domain\Members\MemberId;

class RegistrationRequestTest extends AggregateRootScenarioTestCase
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
                    ISBN::fromString("0534408133"),
                    1500
                );
            })
            ->then([
                new BookWasOffered(
                    $bookId,
                    $memberId,
                    ISBN::fromString("0534408133"),
                    1500
                )
            ]);
    }
}
