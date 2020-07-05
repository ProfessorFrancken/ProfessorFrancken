<?php

declare(strict_types=1);

namespace Francken\Study\BooksSale\Http;

use Francken\Study\BooksSale\Book;

final class ApiBooksController
{
    public function index() : array
    {
        $legacy_books = Book::all();

        return [
            'books' => $legacy_books->map(
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
