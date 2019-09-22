<?php

declare(strict_types=1);

namespace Francken\Domain\Books\Events;

use Broadway\Serializer\Serializable as SerializableInterface;
use Francken\Domain\Books\BookId;
use Francken\Domain\Books\Guest;
use Francken\Domain\Serializable;

final class BookSoldToNonMember implements SerializableInterface
{
    use Serializable;

    private $bookId;
    private $guest;

    public function __construct(BookId $id, Guest $guest)
    {
        $this->bookId = $id;
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
