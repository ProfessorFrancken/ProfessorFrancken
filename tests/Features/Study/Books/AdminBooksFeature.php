<?php

declare(strict_types=1);

namespace Francken\Features\Study\Books;

use DateTimeImmutable;
use Francken\Association\LegacyMember;
use Francken\Features\LoggedInAsAdmin;
use Francken\Features\TestCase;
use Francken\Study\BooksSale\Book;
use Francken\Study\BooksSale\Http\AdminBooksController;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminBooksFeature extends TestCase
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

        $buyer = factory(LegacyMember::class)->create();
        $seller = factory(LegacyMember::class)->create();

        $this->seePageIs(action([AdminBooksController::class, 'show'], ['book' => $book]))
            ->type(2, 'edition')
            ->type($seller->id, 'seller_id')
            ->type($buyer->id, 'buyer_id')
            ->type('2020-01-01', 'purchase_date')
            ->type('2020-01-02', 'sale_date')
            ->check('sold')
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

    /** @test */
    public function it_allows_to_search_for_books() : void
    {
        $availableBook = factory(Book::class)->create([
            'buyer_id' => null,
            'taken_in_by_buyer_at' => null,
            'has_been_sold' => false,
            'paid_off' => false,
        ]);

        $soldBook = factory(Book::class)->create([
            'buyer_id' => factory(LegacyMember::class)->create()->id,
            'taken_in_by_buyer_at' => new DateTimeImmutable(),
            'has_been_sold' => true,
            'paid_off' => false,
        ]);

        $paidOffBook = factory(Book::class)->create([
            'buyer_id' => factory(LegacyMember::class)->create()->id,
            'taken_in_by_buyer_at' => new DateTimeImmutable(),
            'has_been_sold' => true,
            'paid_off' => true,
        ]);

        $this->visit(action([AdminBooksController::class, 'index'], ['select' => 'available']))
            ->see($availableBook->title)
            ->dontSee($soldBook->title)
            ->dontSee($paidOffBook->title)
            ->visit(action([AdminBooksController::class, 'index'], ['select' => 'sold']))
            ->dontSee($availableBook->title)
            ->see($soldBook->title)
            ->dontSee($paidOffBook->title)
            ->visit(action([AdminBooksController::class, 'index'], ['select' => 'paid-off']))
            ->dontSee($availableBook->title)
            ->dontSee($soldBook->title)
            ->see($paidOffBook->title);

        // We can search for a book's title, buyer or seller
        $this->visit(action([AdminBooksController::class, 'index'], ['select' => 'all']))
            ->type($paidOffBook->title, 'title')
            ->type($paidOffBook->buyer_id, 'buyer_id')
            ->type($paidOffBook->seller_id, 'seller_id')
            ->press('Apply filters')
            ->see($paidOffBook->title)
            ->dontSee($soldBook->title)
            ->dontSee($availableBook->title);
    }

    /** @test */
    public function a_book_that_has_been_sold_cant_be_removed() : void
    {
        $book = factory(Book::class)->create([
            'buyer_id' => factory(LegacyMember::class)->create()->id,
        ]);
        $this->delete(action([AdminBooksController::class, 'remove'], ['book' => $book]));
        $this->assertRedirectedTo(action([AdminBooksController::class, 'show'], ['book' => $book]));
    }
}
