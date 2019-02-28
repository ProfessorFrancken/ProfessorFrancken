<?php

declare(strict_types=1);

namespace Francken\Features\Admin;

use Francken\Features\LoggedInAsAdmin;
use Francken\Features\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BooksFeature extends TestCase
{
    use DatabaseMigrations;
    use LoggedInAsAdmin;
    use DatabaseTransactions;

    private $books;

    /** @test */
    public function a_list_of_news_is_shown() : void
    {
        $this->visit('/admin/study/books');

        $this->assertResponseOk();
    }

    /** @test */
    public function putting_a_book_on_sale() : void
    {
        $this->visit('/admin/study/books/create')
            ->see('Put a book on sale');

        $this->type('Introduction to classical mechanics', 'title')
            ->type('1', 'edition')
            ->type('David  Morin', 'author')
            ->type('1139468375', 'isbn')
            ->select('Mark Redeman', 'seller')
            ->type('1337', 'price')
            ->press('Add book');

        $this->see('Introduction to classical mechanics')
            ->see('€1337,00');
    }

    // printing a book form

    // removing a book and providing a reason for removal
}
