<?php

namespace Francken\Application\Books;

use Francken\Domain\Books\ISBN;

interface BookDetailsRepositoryI
{
	public function getByISBN(string $isbn) : BookDetails;
}