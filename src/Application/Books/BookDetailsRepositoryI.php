<?php

declare(strict_types=1);

namespace Francken\Application\Books;

interface BookDetailsRepositoryI
{
    public function getByISBN(string $isbn) : BookDetails;
}
