<?php

declare(strict_types=1);

namespace Francken\Study\BooksSale;

use Francken\Study\BooksSale\AvailableBooks\BookDetails;
use Francken\Study\BooksSale\AvailableBooks\BookDetailsRepository;

final class InMemoryBookDetailsRepository implements BookDetailsRepository
{
    private $isbns = [];

    public function __construct(array $books = [])
    {
        $this->isbns = $books;
    }
    public function getByISBN(string $isbn) : BookDetails
    {
        $book = $this->isbns[$isbn] ?? ['title' => 'unkown', 'author' => 'John & Jane Doe'];

        return new BookDetails(
            $book['title'],
            $book['author'],
            'http://images.amazon.com/images/P/' . $isbn . '.jpg'
        );
    }
}
