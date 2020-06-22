<?php

declare(strict_types=1);

namespace Francken\Study\BooksSale\AvailableBooks;

use Francken\Study\BooksSale\BookId;

interface AvailableBooksRepository
{
    public function save(AvailableBook $book);

    public function find(BookId $id) : AvailableBook;

    public function findAll() : array;

    public function remove(BookID $id);
}
