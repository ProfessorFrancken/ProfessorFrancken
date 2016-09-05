<?php

declare(strict_types=1);

namespace Francken\Tests\Application\Books;

use Francken\Application\Books\BookDetailsRepositoryI;
use Francken\Application\Books\BooksProjector;
use Francken\Application\Books\Book;
use Francken\Application\Projector;
use Francken\Infrastructure\Repositories\InMemoryRepository;
use Francken\Tests\Application\ProjectorScenarioTestCase as TestCase;

class BooksProjectorTest extends TestCase
{
    // how do I instantiate $bookDetailRep?
    // Should I make an additional testable BookDetailRepo?
    private $bookDetailRepo;

    /** @test */
    public function it_stores_a_book()
    {
        $bookId = BookId::generate();
        $sellersId = MemberId::generate();

        $this->scenario->when(
            new BookOffered($bookId, $sellersId, "0534408133", 1500)
        )->then([
        ]);
    }

    protected function createProjector(InMemoryRepository $repository) : Projector
    {

        return new BooksProjector($repository, $this->bookDetailRepo);
    }
}
