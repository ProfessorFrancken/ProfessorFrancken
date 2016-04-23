<?php

namespace Francken\Domain\Books\Events;

final class BookWasOffered implements SerializableInterface
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
        return ['committeeId' => [CommitteeId::class, 'deserialize']];
    }
}
