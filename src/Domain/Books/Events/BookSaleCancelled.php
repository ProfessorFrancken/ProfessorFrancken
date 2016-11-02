<?php

namespace Francken\Domain\Books\Events;

use Broadway\Serializer\SerializableInterface;
use Francken\Domain\Base\Serializable;
use Francken\Domain\Books\BookId;

final class BookSaleCancelled implements SerializableInterface
{
    use Serializable;

    private $bookId;

    public function __construct(BookId $id)
    {
        $this->bookId = $id;
    }

    public function bookId() : BookId
    {
        return $this->bookId;
    }

    protected static function deserializationCallbacks()
    {
        return ['bookId' => [BookId::class, 'deserialize']];
    }
}
