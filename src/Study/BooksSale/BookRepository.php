<?php

declare(strict_types=1);

namespace Francken\Study\BooksSale;

use Broadway\EventSourcing\EventSourcingRepository;
use Francken\Study\BooksSale\BookId;
use Francken\Study\BooksSale\LegacyBook;

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

    
    public function load(BookId $BookId) : LegacyBook
    {
        return $this->repo->load((string)$BookId);
    }

    
    public function save(LegacyBook $Book) : void
    {
        $this->repo->save($Book);
    }
}
