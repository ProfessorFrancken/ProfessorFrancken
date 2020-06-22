<?php

declare(strict_types=1);

namespace Francken\Study\BooksSale\Events;

use Broadway\Serializer\Serializable as SerializableInterface;
use Francken\Study\BooksSale\BookId;
use Francken\Study\BooksSale\Guest;
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
