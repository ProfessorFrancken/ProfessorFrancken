<?php

namespace Francken\Activities\Events;

use Francken\Activities\ActivityId;
use Francken\Members\MemberId;

final class MemberRegisteredToParticipate extends ActivityEvent
{
    protected $memberId;

    public function __construct(ActivityId $id, MemberId $memberId)
    {
        parent::__construct($id);

        $this->memberId = $memberId;
    }

    public function memberId()
    {
        return $this->memberId;
    }

    protected static function deserializationCallbacks()
    {
        return [
            'id' => [ActivityId::class, 'deserialize'],
            'memberId' => [MemberId::class, 'deserialize']
        ];
    }
}
