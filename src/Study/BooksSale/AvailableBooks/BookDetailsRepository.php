<?php

declare(strict_types=1);

namespace Francken\Study\BooksSale\AvailableBooks;

use Francken\Study\BooksSale\AvailableBooks\BookDetails;

interface BookDetailsRepository
{
    public function getByISBN(string $isbn) : BookDetails;
}
