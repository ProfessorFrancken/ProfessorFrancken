<?php

namespace Francken\Infrastructure\Books;

use Francken\Application\Books\BookDetails;
use Francken\Application\Books\BookDetailsRepositoryI;

class BookDetailsRepository implements BookDetailsRepositoryI
{
    public function getByISBN(string $isbn) : BookDetails
    {
        $curl = curl_init('https://www.amazon.com/dp/' . $isbn);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $subject = curl_exec($curl);

        curl_close($curl);

        $pattern = '/<title>(.*): (.*): [0-9,X]*: Amazon.com: /';

        preg_match($pattern, $subject, $matches);

        ///@todo error handling?

        return new BookDetails(
            $matches[1],
            $matches[2],
            'http://images.amazon.com/images/P/' . $isbn . '.jpg'
        );
    }
}
