<?php

namespace Francken\Committees\Events;

use Francken\Committees\CommitteeId;
use Francken\Base\DomainEvent;
use Broadway\Serializer\SerializableInterface;
use BroadwaySerialization\Serialization\Serializable;

final class CommitteeInstantiated implements SerializableInterface
{
    use Serializable;

    private $committeeId;
    private $name;
    private $goal;

    public function __construct(CommitteeId $committeeId, $name, $goal)
    {
        $this->committeeId = $committeeId;
        $this->name = $name;
        $this->goal = $goal;
    }

    public function committeeId()
    {
        return $this->committeeId;
    }

    public function name()
    {
        return $this->name;
    }

    public function goal()
    {
        return $this->goal;
    }

    protected static function deserializationCallbacks()
    {
        return [
            'committeeId' => [CommitteeId::class, 'deserialize']
        ];
    }
}
