<?php

declare(strict_types=1);

namespace Francken\Domain\Committees\Events;

use Broadway\Serializer\SerializableInterface;
use BroadwaySerialization\Serialization\Serializable;
use Francken\Domain\Committees\CommitteeId;

final class CommitteeNameChanged implements SerializableInterface
{
    use Serializable;

    private $committeeId;
    private $name;

    public function __construct(CommitteeId $committeeId, string $name)
    {
        $this->committeeId = $committeeId;
        $this->name = $name;
    }

    public function committeeId() : CommitteeId
    {
        return $this->committeeId;
    }

    public function name() : string
    {
        return $this->name;
    }

    protected static function deserializationCallbacks()
    {
        return ['committeeId' => [CommitteeId::class, 'deserialize']];
    }
}
