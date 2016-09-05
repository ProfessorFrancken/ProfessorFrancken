<?php

declare(strict_types=1);

namespace Francken\Tests\Application\Books;

use Francken\Tests\Application\ReadModelTestCase as TestCase;
use Francken\Application\Books\Book;
use Francken\Domain\Books\BookId;

class BookTest extends TestCase
{
    /** @test */
    function a_book_has_a_title_and_authors()
    {
        $id = BookId::generate();

        $book = new Book(
            $id,
            "Domain-driven design",
            "Eric J. Evans",
            1599,
            "0534408133",
            "www.blabla.jpg");

        $this->assertEquals($book->getId(), (string)$id);
        $this->assertEquals($book->bookId(), $id);
        $this->assertEquals($book->title(), "Domain-driven design");
        $this->assertEquals($book->author(), "Eric J. Evans");
        $this->assertEquals($book->price(), 1599);
        $this->assertEquals($book->isbn(), "0534408133");
        $this->assertEquals($book->pathToCover(), "www.blabla.jpg");
    }

    protected function createInstance() : Book
    {
        $id = BookId::generate();

        return new Book(
            $id,
            "Domain-driven design",
            "Eric J. Evans",
            1599,
            "0534408133",
            "www.blabla.jpg");
    }
}
