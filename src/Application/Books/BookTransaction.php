<?php

namespace Francken\Application\Books;

use Assert\Assertion;
use BroadwaySerialization\Serialization\Serializable;
use Broadway\ReadModel\ReadModelInterface;
use Broadway\Serializer\SerializableInterface;

use Francken\Domain\Books\BookId;
use Francken\Domain\Members\MemberId;

final class BookTransaction implements ReadModelInterface, SerializableInterface
{

    use Serializable;

    private $id;
    private $title;
    private $sellersId;
    private $sellersName;
    private $buyersId;
    private $buyersName;
    private $price;
    private $isSold;
    private $isPaid;

    public function __construct(
        BookId $id,
        string $title,
        MemberId $sellersId,
        string $sellerName,
        MemberId $buyersId,
        string $buyersName,
        int $price,
        bool $isSold,
        bool $isPaid)
    {
        $this->id = $id;
        $this->title = $title;
        $this->sellersId = $sellersId;
        $this->sellersName = $sellersName;
        $this->buyersId = $buyersId;
        $this->buyersName = $buyersName;
        $this->price = $price;
        $this->isPaid = $isPaid;
        $this->isSold = $isSold;
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

    public function sellersId ()
    {
        return $this->sellersId;
    }

    public function sellersName ()
    {
        return $this->sellersName;
    }

    public function buyersId ()
    {
        return $this->buyersId;
    }

    public function buyersName ()
    {
        return $this->buyersName;
    }

    public function price ()
    {
        return $this->price;
    }

    public function isPaid ()
    {
        return $this->isPaid;
    }

    public function isSold ()
    {
        return $this->isSold;
    }

}
