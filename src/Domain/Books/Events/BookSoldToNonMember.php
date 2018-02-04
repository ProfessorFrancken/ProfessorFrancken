<?php

namespace Francken\Domain\Books\Events;

use Broadway\Serializer\Serializable as SerializableInterface;
use Francken\Domain\Serializable;
use Francken\Domain\Books\BookId;
use Francken\Domain\Books\Guest;

final class BookSoldToNonMember implements SerializableInterface
{
    use Serializable;

    private $id;
    private $guest;

    public function __construct(BookId $id, Guest $guest)
    {
        $this->id = $id;
        $this->guest = $guest;
    }

    public function bookId() : BookId
    {
        return $this->bookId;
    }

    public function guest() : Guest
    {
        return $this->guest;
    }

    protected static function deserializationCallbacks()
    {
        return ['bookId' => [BookId::class, 'deserialize']];
    }
}
