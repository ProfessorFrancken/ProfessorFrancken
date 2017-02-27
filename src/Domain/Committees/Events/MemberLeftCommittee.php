<?php

declare(strict_types=1);

namespace Francken\Domain\Committees\Events;

use Broadway\Serializer\SerializableInterface;
use BroadwaySerialization\Serialization\Serializable;
use Francken\Domain\Committees\CommitteeId;
use Francken\Domain\Members\MemberId;

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
