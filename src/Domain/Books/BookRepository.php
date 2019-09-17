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

    
    public function load(BookId $BookId) : Book
    {
        return $this->repo->load((string)$BookId);
    }

    
    public function save(Book $Book) : void
    {
        $this->repo->save($Book);
    }
}
