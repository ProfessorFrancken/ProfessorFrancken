<?php

declare(strict_types=1);

namespace Francken\Tests\Application\Books;

use Francken\Application\Books\BookDetails;

class BookDetailsTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    function a_book_has_a_title_and_authors()
    {
        $bookDetail = new BookDetails(
            'Domain-driven design',
            'Eric J. Evans',
            'www.blabla.jpg'
        );

        $this->assertEquals($bookDetail->title(), 'Domain-driven design');
        $this->assertEquals($bookDetail->author(), 'Eric J. Evans');
        $this->assertEquals($bookDetail->pathToCover(), 'www.blabla.jpg');
    }
}
