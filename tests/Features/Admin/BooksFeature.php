<?php

declare(strict_types=1);

namespace Francken\Features\Admin;

use Faker\Factory;
use Francken\Features\LoggedInAsAdmin;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Francken\Features\TestCase;

class BooksFeature extends TestCase
{
    use DatabaseMigrations;
    use LoggedInAsAdmin;
    use DatabaseTransactions;

    private $books;

    /** @test */
    function a_list_of_news_is_shown()
    {
        $this->visit('/admin/study/books');

        $this->assertResponseOk();
    }

    /** @test */
    function putting_a_book_on_sale()
    {
        $this->visit('/admin/study/books');

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
