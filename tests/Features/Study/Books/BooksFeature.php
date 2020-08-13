<?php


declare(strict_types=1);

namespace Francken\Features\Study\Books;

use Francken\Features\TestCase;
use Francken\Study\BooksSale\Book;
use Francken\Study\BooksSale\Http\BooksController;

class BooksFeature extends TestCase
{
    /** @test */
    public function it_shows_available_books() : void
    {
        $book = factory(Book::class)->create([
            'buyer_id' => null,
            'taken_in_by_buyer_at' => null,
            'has_been_sold' => false,
            'paid_off' => false,
        ]);

        $this->visit(action([BooksController::class, 'index']))
            ->see($book->title);

        $this->visit(action([BooksController::class, 'show'], ['book' => $book]))
            ->assertResponseOk();
    }
}
