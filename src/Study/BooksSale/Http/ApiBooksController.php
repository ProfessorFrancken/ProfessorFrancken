<?php

declare(strict_types=1);

namespace Francken\Study\BooksSale\Http;

use Francken\Study\BooksSale\Book;

final class ApiBooksController
{
    public function index() : array
    {
        $legacyBooks = Book::all();

        return [
            'books' => $legacyBooks->map(
                function (Book $book) : array {
                    return [
                        'title' => $book->naam,
                        'author' => $book->auteur,
                        'isbn' => $book->isbn,
                        'cover' => '',
                        'price_in_cents' => $book->price * 100,
                    ];
                }
            )->values()
        ];
    }
}
