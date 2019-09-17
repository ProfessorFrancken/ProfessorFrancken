<?php

declare(strict_types=1);

namespace Francken\Application\Books;

interface BookDetailsRepository
{
    public function getByISBN(string $isbn) : BookDetails;
}
