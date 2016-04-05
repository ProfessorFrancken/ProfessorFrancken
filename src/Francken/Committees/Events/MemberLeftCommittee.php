<?php

namespace Francken\Committees\Events;

use Francken\Committees\CommitteeId;
use Francken\Members\MemberId;
use Broadway\Serializer\SerializableInterface;
use BroadwaySerialization\Serialization\Serializable;

final class MemberLeftCommittee implements SerializableInterface
{
    use Serializable;

    private $committeeId;
    private $memberId;

    public function __construct(CommitteeId $committeeId, MemberId $memberId)
    {
        $this->committeeId = $committeeId;
        $this->memberId = $memberId;
    }

    public function committeeId() : CommitteeId
    {
        return $this->committeeId;
    }

    public function memberId() : MemberId
    {
        return $this->memberId;
    }

    protected static function deserializationCallbacks()
    {
        return [
            'committeeId' => [CommitteeId::class, 'deserialize'],
            'memberId' => [MemberId::class, 'deserialize']
        ];
    }
}
