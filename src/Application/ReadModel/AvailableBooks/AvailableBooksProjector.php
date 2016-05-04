<?php

namespace Francken\Application\ReadModel\AvailableBooks;

use Broadway\ReadModel\Projector;
use Francken\Application\ReadModel\AvailableBooks\AvailableBooks;



final class AvailableBooksProjector extends Projector
{
	public function applyBookWasOffered(BookWasOffered $event)
	{
		AvailableBooks::create([
			'id' => $event->bookId(), //bookId
			'isbn' => $event->ISBN(),
			'price' => $event->price(), //in cents
			]);
	}

	public function applyBookSoldToMember(BookSoldToMember $event)
	{
		AvailableBooks::destroy($event->bookId());
	}

	public function applyBookSoldToNonMember(BookSoldToNonMember $event)
	{
		AvailableBooks::destroy($event->bookId());
	}

	public function applyBookSaleCancelled(BookSaleCancelled $event)
	{
		
	}
}
