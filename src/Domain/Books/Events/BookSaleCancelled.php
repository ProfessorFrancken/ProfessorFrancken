<?php

namespace Francken\Domain\Books\Events;

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
        return ['committeeId' => [CommitteeId::class, 'deserialize']];
    }
}
