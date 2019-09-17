<?php

declare(strict_types=1);

namespace Francken\Domain\Committees\Events;

use Broadway\Serializer\Serializable as SerializableInterface;
use Francken\Domain\Committees\CommitteeId;
use Francken\Domain\Serializable;

final class CommitteeInstantiated implements SerializableInterface
{
    use Serializable;

    private $committeeId;
    private $name;
    private $goal;

    public function __construct(CommitteeId $committeeId, string $name, string $goal)
    {
        $this->committeeId = $committeeId;
        $this->name = $name;
        $this->goal = $goal;
    }

    public function committeeId() : CommitteeId
    {
        return $this->committeeId;
    }

    public function name() : string
    {
        return $this->name;
    }

    public function goal() : string
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
