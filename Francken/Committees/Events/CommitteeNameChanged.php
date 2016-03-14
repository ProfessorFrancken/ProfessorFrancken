<?php

namespace Francken\Committees\Events;

use Francken\Committees\CommitteeId;
use Francken\Base\DomainEvent;
use Broadway\Serializer\SerializableInterface;
use BroadwaySerialization\Serialization\Serializable;

final class CommitteeNameChanged implements SerializableInterface
{
    use Serializable;

    private $committeeId;
    private $name;

    public function __construct(CommitteeId $committeeId, $name)
    {
        $this->committeeId = $committeeId;
        $this->name = $name;
    }

    public function committeeId()
    {
        return $this->committeeId;
    }

    public function name()
    {
        return $this->name;
    }

    protected static function deserializationCallbacks()
    {
        return [];
    }
}
