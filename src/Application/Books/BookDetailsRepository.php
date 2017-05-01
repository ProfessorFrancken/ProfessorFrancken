<?php

namespace Francken\Application\Books;

interface BookDetailsRepository
{
    public function getByISBN(string $isbn) : BookDetails;
}
