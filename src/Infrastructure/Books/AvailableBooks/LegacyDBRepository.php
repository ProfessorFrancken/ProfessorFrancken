<?php

declare(strict_types=1);

namespace Francken\Infrastructure\Books\AvailableBooks;

use DB;
use Francken\Application\Books\AvailableBook;
use Francken\Application\Books\AvailableBooksRepository;
use Francken\Domain\Books\BookId;

/**
 * This repository is used to retrieve books from our legacy database
 * it used while we're switching the current legacy system with the
 * new system and should be removed once we've fully switched.
 */
final class LegacyDBRepository implements AvailableBooksRepository
{
    public function find(BookId $id) : AvailableBook
    {
        $boek = DB::connection('francken-legacy')
            ->table("boeken")
            ->where('id', (string)$id)
            ->first();

        return ($this->mapDbBoekToAvailableBook())($boek);
    }

    public function findAll() : array
    {
        return DB::connection('francken-legacy')
            ->table("boeken")
            ->where('verkoopdatum', null)
            ->where('verkocht', false)
            ->where('afgerekend', false)
            ->orderBy('naam', 'asc')
            ->orderBy('editie', 'desc')
            ->get()
            ->map($this->mapDbBoekToAvailableBook())
            ->toArray();
    }

    public function save(AvailableBook $book) : void
    {
        throw new \Exception("Tried to save a book to the legacy system, which is not allowed");
    }

    public function remove(BookID $id) : void
    {
        throw new \Exception("Tried to remove a book from the legacy system, which is not allowed");
    }

    private function mapDbBoekToAvailableBook()
    {
        return function ($boek) {
            return new AvailableBook(
                BookId::fromLegacyId($boek->id),
                $boek->naam,
                $boek->auteur,
                100 * $boek->prijs,
                $boek->isbn,
                'http://images.amazon.com/images/P/' . $boek->isbn . '.jpg',
                false
            );
        };
    }
}
