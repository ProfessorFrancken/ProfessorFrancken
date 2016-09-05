<?php

declare(strict_types=1);

namespace Francken\Domain\Books;

use Broadway\EventSourcing\EventSourcingRepository;

final class BookRepository
{
    /**
     * @var EventSourcingRepository
     */
    private $repo;

    /**
     * BookRepository constructor.
     * @param $repo
     */
    public function __construct(EventSourcingRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @param BookId $BookId
     * @return Book
     */
    public function load(BookId $BookId) : Book
    {
return $this->repo->load((string)$BookId);
    }

    /**
     * @param Book $Book
     */
    public function save(Book $Book)
    {
        $this->repo->save($Book);
    }
}
