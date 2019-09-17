<?php

declare(strict_types=1);

namespace Francken\Domain\Books\Events;

use Broadway\Serializer\Serializable as SerializableInterface;
use Francken\Domain\Books\BookId;
use Francken\Domain\Serializable;

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
