<?php

declare(strict_types=1);

namespace Francken\Application\Books;

use Francken\Application\ReadModelRepository;
use Francken\Domain\Books\BookId;

final class AvailableBooksRepository
{
    private $repo;

    public function __construct(ReadModelRepository $repo)
    {
        $this->repo = $repo;
    }

    public function save(AvailableBook $book)
    {
        $this->repo->save($book);
    }

    public function find(BookId $id) : AvailableBook
    {
        return $this->repo->find((string)$id);
    }

    public function findAll() : array
    {
        return $this->repo->findAll();
    }

    public function remove(BookID $id)
    {
        $this->repo->remove((string)$id);
    }
}
