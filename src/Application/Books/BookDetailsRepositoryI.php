<?php

namespace Francken\Application\Books;

interface BookDetailsRepositoryI
{
    public function getByISBN(string $isbn) : BookDetails;
}
