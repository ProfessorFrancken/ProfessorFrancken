<?php

namespace Francken\Committees\Events;

use Francken\Committees\CommitteeId;
use Francken\Base\DomainEvent;
use Broadway\Serializer\SerializableInterface;
use BroadwaySerialization\Serialization\Serializable;

final class MemberLeftCommittee implements SerializableInterface
{
    use Serializable;

    private $committeeId;
    private $memberId;

    public function __construct(CommitteeId $committeeId, $memberId)
    {
        $this->committeeId = $committeeId;
        $this->memberId = $memberId;
    }

    public function committeeId()
    {
        return $this->committeeId;
    }

    public function memberId()
    {
        return $this->memberId;
    }

    protected static function deserializationCallbacks()
    {
        return [];
    }
}
