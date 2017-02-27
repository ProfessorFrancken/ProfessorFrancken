<?php

declare(strict_types=1);

namespace Francken\Domain\Committees\Events;

use Broadway\Serializer\SerializableInterface;
use BroadwaySerialization\Serialization\Serializable;
use Francken\Domain\Committees\CommitteeId;
use Francken\Domain\Members\Email;

final class CommitteeEmailChanged implements SerializableInterface
{
    use Serializable;

    private $committeeId;
    private $email;

    public function __construct(CommitteeId $committeeId, Email $email = null)
    {
        $this->committeeId = $committeeId;
        $this->email = $email;
    }

    public function committeeId() : CommitteeId
    {
        return $this->committeeId;
    }

    public function email()
    {
        return $this->email;
    }

    protected static function deserializationCallbacks()
    {
        return ['committeeId' => [CommitteeId::class, 'deserialize']];
    }
}
