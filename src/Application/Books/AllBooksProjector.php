<?php

namespace Francken\Application\Books;

use Francken\Application\ReadModel\MemberList\MemberList;

use Broadway\ReadModel\Projector;
use Francken\Domain\Books\Events\BookOffered;
use Francken\Domain\Books\Events\BookOfferRetracted;
use Francken\Domain\Books\Events\BookSoldToMember;
use Francken\Domain\Books\Events\BookSaleCancelled;
use Francken\Domain\Books\Events\BookSaleCompleted;

final class AllBooksProjector extends Projector
{
    private $bookDetailRepository;

    public function __construct(BookDetailsRepositoryI $repo)
    {
        $this->bookDetailRepository = $repo;
    }

    public function applyBookOffered(BookOffered $event)
    {
        $bookDetails = $this->bookDetailRepository->getByISBN($event->isbn());

        AllBooks::create([
            'id' => $event->bookId(),
            'title' => $bookDetails->title(),
            'authors' => $bookDetails->authors(),
            'price' => $event->price(),
            'isbn-10' => $event->isbn(),
            'path_to_cover' => $bookDetails->pathToCover(),
            'price' => $event->price(),
            'sold_by' => 'Mark Boer',
                // MemberList::where('uuid', $event->sellersId())->first()->first_name .
                // MemberList::where('uuid', $event->sellersId())->first()->last_name,
            'state' => 'available']);
    }

    public function applyBookOfferRetracted(BookOfferRetracted $event)
    {
        AllBooks::find($event->bookId())->destroy();
    }

    public function applyBookSoldToMember(BookSoldToMember $event)
    {
        AllBooks::find($event->bookId())
            ->update([
                'state' => 'pending',
                 'sold_to' => 
                    MemberList::where('uuid', $event->buyersId())->first()->first_name .
                    MemberList::where('uuid', $event->buyersId())->first()->last_name
            ]);
    }

    public function applyBookSaleCancelled(BookSaleCancelled $event)
    {
        AllBooks::find($event->bookId())->destroy(); 
    }

    public function applyBookSaleCompleted(BookSaleCompleted $event)
    {
        AllBooks::find($event->bookId())
            ->update(['state' => 'sold']);
    }
}
