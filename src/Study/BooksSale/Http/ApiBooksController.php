<?php

declare(strict_types=1);

namespace Francken\Study\BooksSale\Http;

use Francken\Study\BooksSale\LegacyBook;

final class ApiBooksController
{
    public function index()
    {
        $legacy_books = LegacyBook::all();

        return [
            'books' => $legacy_books->map(
                function (LegacyBook $book) {
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
