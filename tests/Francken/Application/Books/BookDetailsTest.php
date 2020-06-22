<?php

declare(strict_types=1);

namespace Francken\Tests\Application\Books;

use Francken\Study\BooksSale\AvailableBooks\BookDetails;

class BookDetailsTest extends \PHPUnit\Framework\TestCase
{
    /** @test */
    public function a_book_has_a_title_and_authors() : void
    {
        $bookDetail = new BookDetails(
            "Domain-driven design",
            "Eric J. Evans",
            "www.blabla.jpg");

        $this->assertEquals($bookDetail->title(), "Domain-driven design");
        $this->assertEquals($bookDetail->author(), "Eric J. Evans");
        $this->assertEquals($bookDetail->pathToCover(), "www.blabla.jpg");
    }
}
