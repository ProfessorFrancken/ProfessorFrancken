<?php

namespace Francken\Domain\Books\Events;

final class BookSaleCancelled implements SerializableInterface
{
    use Serializable;

    private $bookId;
    private $sellersId;

    public function __construct(BookId $id, MemberId $sellersId)
    {
    	$this->bookId = $id;
    	$this->sellersId = $sellersId;
    }

    public function bookId() : BookId
    {
    	return $this->bookId;
    }

    public function sellersId() : MemberId
    {
    	return $this->sellersId;
    } 
    
    protected static function deserializationCallbacks()
    {
        return ['committeeId' => [CommitteeId::class, 'deserialize']];
    }
}
