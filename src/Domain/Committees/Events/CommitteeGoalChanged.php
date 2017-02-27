<?php

declare(strict_types=1);

namespace Francken\Domain\Committees\Events;

use Broadway\Serializer\SerializableInterface;
use BroadwaySerialization\Serialization\Serializable;
use Francken\Domain\Committees\CommitteeId;

final class CommitteeGoalChanged implements SerializableInterface
{
    use Serializable;

    private $committeeId;
    private $goal;

    public function __construct(CommitteeId $committeeId, string $goal)
    {
        $this->committeeId = $committeeId;
        $this->goal = $goal;
    }

    public function committeeId() : CommitteeId
    {
        return $this->committeeId;
    }

    public function goal() : string
    {
        return $this->goal;
    }

    protected static function deserializationCallbacks()
    {
        return ['committeeId' => [CommitteeId::class, 'deserialize']];
    }
}
