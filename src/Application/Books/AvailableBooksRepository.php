<?php

declare(strict_types=1);

namespace Francken\Application\Books;

use Francken\Domain\Books\BookId;

interface AvailableBooksRepository
{
    public function save(AvailableBook $book);

    public function find(BookId $id) : AvailableBook;

    public function findAll() : array;

    public function remove(BookID $id);
}
