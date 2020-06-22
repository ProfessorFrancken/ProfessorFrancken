<?php

declare(strict_types=1);

namespace Francken\Study\BooksSale\AvailableBooks;

use Francken\Study\BooksSale\AvailableBooks\AvailableBook;
use Francken\Study\BooksSale\AvailableBooks\AvailableBooksRepository;
use Francken\Application\ReadModelRepository;
use Francken\Study\BooksSale\BookId;

/**
 * This implementation is used by the projections and should be used
 * once we've fully switched systems
 */
final class ProjectionRepository implements AvailableBooksRepository
{
    private $repo;

    public function __construct(ReadModelRepository $repo)
    {
        $this->repo = $repo;
    }

    public function save(AvailableBook $book) : void
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

    public function remove(BookID $id) : void
    {
        $this->repo->remove((string)$id);
    }
}
