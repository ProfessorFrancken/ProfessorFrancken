<?php

declare(strict_types=1);

namespace Francken\Tests\Application\Books;

use Francken\Study\BooksSale\AvailableBooks\AvailableBook;
use Francken\Domain\Books\BookId;
use Francken\Tests\Application\ReadModelTestCase;

class AvailableBookTest extends ReadModelTestCase
{
    /** @test */
    public function a_book_has_a_title_and_authors() : void
    {
        $id = BookId::generate();

        $book = new AvailableBook(
            $id,
            "Domain-driven design",
            "Eric J. Evans",
            1599,
            "0534408133",
            "www.blabla.jpg",
            false);

        $this->assertEquals($book->getId(), (string)$id);
        $this->assertEquals($book->bookId(), $id);
        $this->assertEquals($book->title(), "Domain-driven design");
        $this->assertEquals($book->author(), "Eric J. Evans");
        $this->assertEquals($book->price(), 1599);
        $this->assertEquals($book->isbn(), "0534408133");
        $this->assertEquals($book->pathToCover(), "www.blabla.jpg");
        $this->assertEquals($book->salePending(), false);
    }

    protected function createInstance() : AvailableBook
    {
        $id = BookId::generate();

        return new AvailableBook(
            $id,
            "Domain-driven design",
            "Eric J. Evans",
            1599,
            "0534408133",
            "www.blabla.jpg",
            false);
    }
}
