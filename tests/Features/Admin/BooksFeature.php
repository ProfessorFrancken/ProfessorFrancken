<?php

declare(strict_types=1);

namespace Francken\Features\Admin;

use Francken\Features\LoggedInAsAdmin;
use Francken\Features\TestCase;
use Francken\Study\BooksSale\Book;
use Francken\Study\BooksSale\Http\AdminBooksController;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BooksFeature extends TestCase
{
    use DatabaseMigrations;
    use LoggedInAsAdmin;
    use DatabaseTransactions;

    private $books;

    /** @test */
    public function it_allows_us_to_manage_books() : void
    {
        $book = factory(Book::class)->create([
            'buyer_id' => null,
            'taken_in_by_buyer_at' => null,
            'has_been_sold' => false,
            'paid_off' => false,
        ]);

        $this->visit(action([AdminBooksController::class, 'index']))
            ->see($book->title)
            ->click('Add a book')
            ->seePageIs(action([AdminBooksController::class, 'create']))
            ->type('Partial Differential Equations', 'title')
            ->type('Lawrence C. Evans', 'author')
            ->type('8835', 'price')
            ->type('978-0821849743', 'isbn')
            ->type('2020-01-01', 'purchase_date')
            ->press('Add book');

        $book = Book::where('title', 'Partial Differential Equations')->first();

        $this->seePageIs(action([AdminBooksController::class, 'show'], ['book' => $book]))
            ->type(2, 'edition')
            ->press('Update');

        $book->refresh();
        $this->assertEquals(2, $book->edition);

        $this->click('Print')
             ->assertResponseOk();
        // Next remove the book..
        $this->visit(action([AdminBooksController::class, 'show'], ['book' => $book]))
             ->press('here')
             ->assertResponseOk();

        $this->assertNull(Book::where('title', 'Partial Differential Equations')->first());
    }
}
