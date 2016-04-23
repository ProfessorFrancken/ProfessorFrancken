<?php

namespace Francken\Domain\Books;

use Broadway\EventSourcing\EventSourcedAggregateRoot;

final class Book extends EventSourcedAggregateRoot
{
	private $id;
	private $sellersId;
	private $ISBN;
	private $price;
	private $isSold = false;

	public static function offer(BookId $id, MemberId $sellersId, ISBN $isbn, int $price)
	{
		$book = new Book;
		$book->apply(new BookWasOffered($id, $sellersId, $isbn, $price));
		return $book;
	}

	public function sellToMember(MemberId $memberId)
	{
		$this->apply(new BookSoldToMember($id, $sellersId, $memberId));
	}

	public function sellToNonMember(Guest $guest)
	{
		$this->apply(new BookSoldToNonMember($id, $sellersId, $guest));
	}

	public function cancelSale()
	{
		$this->apply(new BookSaleCancelled($id));
	}

	public function applyBookWasOffered(BookWasOffered $event)
	{
		$this->id = $event->id();
		$this->sellersId = $event->sellersId();
		$this->ISBN = $event->ISBN();
		$this->price = $event->price();
	}

	public function applyBookSoldToMember(BookSoldToMember $event)
	{
		if($this->isSold)
			throw new Exception("Books cannot be sold twice");
		$this->isSold = true;		
	}	

	public function applyBookSoldToMember(BookSoldToNonMember $event)
	{
		if($this->isSold)
			throw new Exception("Books cannot be sold twice");
		$this->isSold = true;
	}

	public function applyBookSaleCancelled(BookSaleCancelled $event)
	{
		if($this->isSold)
			throw new Exception("Books cannot be sold twice");
		$this->isSold = false;
	}
}
