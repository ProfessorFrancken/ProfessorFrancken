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
                fn (Book $book) : array => [
                    'title' => $book->title,
                    'author' => $book->author,
                    'isbn' => $book->isbn,
                    'cover' => '',
                    'price_in_cents' => $book->price,
                ]
            )->values()
        ];
    }
}
