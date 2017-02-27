<?php

declare(strict_types=1);

namespace Francken\Tests\Application\Books;

use Francken\Application\Books\AvailableBook;
use Francken\Application\Books\AvailableBooksProjector;
use Francken\Application\Books\AvailableBooksRepository;
use Francken\Application\Books\BookDetails;
use Francken\Application\Books\BookDetailsRepositoryI;
use Francken\Application\Projector;
use Francken\Domain\Books\BookId;
use Francken\Domain\Books\Events\BookOffered;
use Francken\Domain\Books\Events\BookOfferRetracted;
use Francken\Domain\Books\Events\BookSaleCancelled;
use Francken\Domain\Books\Events\BookSaleCompleted;
use Francken\Domain\Books\Events\BookSoldToMember;
use Francken\Domain\Members\MemberId;
use Francken\Infrastructure\Repositories\InMemoryRepository;
use Francken\Tests\Application\ProjectorScenarioTestCase as TestCase;

class AvailableBooksProjectorTest extends TestCase
{
    private $bookDetailRepo;

    /** @test */
    public function it_stores_a_book()
    {
        $bookId = BookId::generate();
        $sellersId = MemberId::generate();

        $this->scenario->when(
            new BookOffered($bookId, $sellersId, '0534408133', 1500)
        )->then([
            new AvailableBook(
                $bookId,
                'title',
                'author',
                1500,
                '0534408133',
                'path_to_cover.jpg',
                false)
        ]);
    }

    /** @test */
    public function an_offer_can_be_cancelled()
    {
        $bookId = BookId::generate();
        $sellersId = MemberId::generate();

        $this->scenario->given([
            new BookOffered($bookId, $sellersId, '0534408133', 1500)
        ])->when(
            new BookOfferRetracted($bookId)
        )->then([]);
    }

    /** @test */
    public function a_book_can_be_sold_to_a_member()
    {
        $bookId = BookId::generate();
        $sellersId = MemberId::generate();
        $buyersId = MemberId::generate();

        $this->scenario->given([
            new BookOffered($bookId, $sellersId, '0534408133', 1500)
        ])->when(
            new BookSoldToMember($bookId, $buyersId)
        )->then([
            new AvailableBook(
                $bookId,
                'title',
                'author',
                1500,
                '0534408133',
                'path_to_cover.jpg',
                true)
        ]);
    }

    /** @test */
    public function a_sale_can_be_cancelled()
    {
        $bookId = BookId::generate();
        $sellersId = MemberId::generate();
        $buyersId = MemberId::generate();

        $this->scenario->given([
            new BookOffered($bookId, $sellersId, '0534408133', 1500),
            new BookSoldToMember($bookId, $buyersId)
        ])->when(
            new BookSaleCancelled($bookId)
        )->then([
            new AvailableBook(
                $bookId,
                'title',
                'author',
                1500,
                '0534408133',
                'path_to_cover.jpg',
                false)
        ]);
    }


    /** @test */
    public function a_sale_can_be_completed()
    {
        $bookId = BookId::generate();
        $sellersId = MemberId::generate();
        $buyersId = MemberId::generate();

        $this->scenario->given([
            new BookOffered($bookId, $sellersId, '0534408133', 1500),
            new BookSoldToMember($bookId, $buyersId)
        ])->when(
            new BookSaleCompleted($bookId)
        )->then([]);
    }



    protected function createProjector(InMemoryRepository $repository) : Projector
    {
        $this->bookDetailRepo = $this->prophesize(BookDetailsRepositoryI::class);

        $this->bookDetailRepo->getByISBN('0534408133')->willReturn(
            new BookDetails(
                'title',
                'author',
                'path_to_cover.jpg'));

        return new AvailableBooksProjector(
            new AvailableBooksRepository(
                $repository
            ),
            $this->bookDetailRepo->reveal()
        );
    }
}
