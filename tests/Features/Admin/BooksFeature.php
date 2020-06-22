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
}
