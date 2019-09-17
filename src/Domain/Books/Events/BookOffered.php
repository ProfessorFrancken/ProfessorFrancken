<?php

declare(strict_types=1);

namespace Francken\Domain\Books\Events;

use Broadway\Serializer\Serializable as SerializableInterface;
use Francken\Domain\Books\BookId;
use Francken\Domain\Members\MemberId;
use Francken\Domain\Serializable;

final class BookOffered implements SerializableInterface
{
    use Serializable;

    private $bookId;
    private $sellersId;
    private $isbn;
    private $price;

    public function __construct(BookId $id, MemberId $sellersId, string $isbn, int $price)
    {
        $this->bookId = $id;
        $this->sellersId = $sellersId;
        $this->isbn = $isbn;
        $this->price = $price;
    }

    public function bookId() : BookId
    {
        return $this->bookId;
    }

    public function sellersId() : MemberId
    {
        return $this->sellersId;
    }

    public function isbn() : string
    {
        return $this->isbn;
    }

    public function price() : int
    {
        return $this->price;
    }

    protected static function deserializationCallbacks()
    {
        return ['bookId' => [BookId::class, 'deserialize'],
                'sellersId' => [MemberId::class, 'deserialize'], ];
    }
}
