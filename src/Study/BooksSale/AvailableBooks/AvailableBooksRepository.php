<?php

declare(strict_types=1);

namespace Francken\Study\BooksSale\AvailableBooks;

use Francken\Domain\Books\BookId;
use Francken\Study\BooksSale\AvailableBooks\AvailableBook;

interface AvailableBooksRepository
{
    public function save(AvailableBook $book);

    public function find(BookId $id) : AvailableBook;

    public function findAll() : array;

    public function remove(BookID $id);
}
