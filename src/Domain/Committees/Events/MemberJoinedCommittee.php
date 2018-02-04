<?php

declare(strict_types=1);

namespace Francken\Domain\Committees\Events;

use Francken\Domain\Members\MemberId;
use Francken\Domain\Committees\CommitteeId;
use Broadway\Serializer\Serializable as SerializableInterface;
use BroadwaySerialization\Serialization\AutoSerializable as Serializable;

final class MemberJoinedCommittee implements SerializableInterface
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
