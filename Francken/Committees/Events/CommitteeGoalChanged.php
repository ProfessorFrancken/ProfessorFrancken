<?php

namespace Francken\Committees\Events;

use Francken\Committees\CommitteeId;
use Francken\Base\DomainEvent;

use Broadway\Serializer\SerializableInterface;
use BroadwaySerialization\Serialization\Serializable;

final class CommitteeGoalChanged implements SerializableInterface
{
    use Serializable;

    private $committeeId;
    private $goal;

    public function __construct(CommitteeId $committeeId, $goal)
    {
        $this->committeeId = $committeeId;
        $this->goal = $goal;
    }

    public function committeeId()
    {
        return $this->committeeId;
    }

    public function goal()
    {
        return $this->goal;
    }

    protected static function deserializationCallbacks()
    {
        return [];
    }
}