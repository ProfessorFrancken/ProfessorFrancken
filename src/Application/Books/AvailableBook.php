<?php

namespace Francken\Application\Books;

use BroadwaySerialization\Serialization\Serializable;
use Broadway\ReadModel\ReadModelInterface;
use Broadway\Serializer\SerializableInterface;
use Francken\Domain\Books\BookId;

final class AvailableBook implements ReadModelInterface, SerializableInterface
{
    use Serializable;

    private $id;
    private $title;
    private $author;
    private $price;
    private $isbn_10;
    private $path_to_cover;
    private $sale_pending;

    public function __construct(
        BookId $id,
        string $title,
        string $author,
        int $price,
        string $isbn_10,
        string $path_to_cover,
        bool $sale_pending
    ) {
        $this->id = (string)$id;
        $this->title = $title;
        $this->author = $author;
        $this->price = $price;
        $this->isbn_10 = $isbn_10;
        $this->path_to_cover = $path_to_cover;
        $this->sale_pending= $sale_pending;
    }

    public function getId()
    {
        return $this->id;
    }

    public function bookId()
    {
        return new BookId($this->id);
    }

    public function title() : string
    {
        return $this->title;
    }

    public function author() : string
    {
        return $this->author;
    }

    public function price() : string
    {
        return $this->price;
    }

    public function isbn() : string
    {
        return $this->isbn_10;
    }

    public function pathToCover() : string
    {
        return $this->path_to_cover;
    }

    public function salePending() : bool
    {
        return $this->sale_pending;
    }
}
