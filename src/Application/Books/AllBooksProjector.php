<?php

namespace Francken\Application\Books;

use Broadway\ReadModel\Projector;

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
            'id' => $event->id(),
            'title' => $bookDetails->title(),
            'authors' => $bookDetails->authors(),
            'price' => $event->price(),
            'isbn' => $event->isbn(),
            'path_to_cover' => $bookDetails->pathToCover(),
            'price' => $event->price(),
            'sold_by' => 
                MemberList::where('uuid', $event->sellersId())->first()->first_name .
                MemberList::where('uuid', $event->sellersId())->first()->last_name,
            'state' => 'available']);
    }

    public function applyBookOfferRetracted(BookOfferRetracted $event)
    {
        AllBooks::find($event->id())->destroy();
    }

    public function applyBookSoldToMember(BookSoldToMember $event)
    {
        AllBooks::find($event->id())
            ->update([
                'state' => 'pending',
                 'sold_to' => 
                    MemberList::where('uuid', $event->buyersId())->first()->first_name .
                    MemberList::where('uuid', $event->buyersId())->first()->last_name
            ]);
    }

    public function applyBookSaleCancelled(BookSaleCancelled $event)
    {
        AllBooks::find($event->id())->destroy(); 
    }

    public function applyBookSaleCompleted(BookSaleCompleted $event)
    {
        AllBooks::find($event->id())
            ->update(['state' => 'sold']);
    }
}
