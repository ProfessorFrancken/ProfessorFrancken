<?php

namespace Francken\Domain\Books\Events;

final class BookWasOffered implements SerializableInterface
{
    use Serializable;

    private $bookId;
    private $sellersId;
    private $ISBN;
    private $price;

    public function __construct(BookId $id, MemberId $sellersId, ISBN $isbn, int $price)
    {
    	$this->bookId = $id;
    	$this->sellersId = $sellersId;
    	$this->ISBN = $ISBN;
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

    public function ISBN() : ISBN
    {
    	return $this->ISBN;
    }

    public function price() : int
    {
    	return $this->price;
    }
    
    protected static function deserializationCallbacks()
    {
        return ['committeeId' => [CommitteeId::class, 'deserialize']];
    }
}
