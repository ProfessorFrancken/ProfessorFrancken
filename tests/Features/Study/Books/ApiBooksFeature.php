<?php

declare(strict_types=1);

namespace Francken\Features\Study\Books;

use Francken\Features\TestCase;
use Francken\Study\BooksSale\Book;
use Francken\Study\BooksSale\Http\ApiBooksController;

class ApiBooksFeature extends TestCase
{
    /** @test */
    public function it_returns_current_job_openings() : void
    {
        factory(Book::class, 3)->create();

        $this->json(
            'GET',
            action([ApiBooksController::class, 'index']),
        )->assertResponseStatus(200)
            ->seeJsonStructure([
            'books' => [[
                "title",
                "author",
                "isbn",
                "cover",
                "price_in_cents",
            ]]
        ]);
    }
}
