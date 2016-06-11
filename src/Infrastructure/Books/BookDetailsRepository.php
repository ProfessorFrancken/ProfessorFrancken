<?php

namespace Francken\Infrastructure\Books;

use Francken\Application\Books\BookDetails;
use Francken\Application\Books\BookDetailsRepositoryI;
use Francken\Domain\Books\ISBN;

class BookDetailsRepository implements BookDetailsRepositoryI 
{
	public function getByISBN(ISBN $isbn) : BookDetails
	{
		return new BookDetails(
			"Kijk nou!",
			"Mark & Mark",
			"https://images-na.ssl-images-amazon.com/images/I/41e-FWfEqsL._SX388_BO1,204,203,200_.jpg");
	}
}