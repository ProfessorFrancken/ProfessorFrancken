<?php

declare(strict_types=1);

namespace Francken\Domain\Committees\Events;

use Francken\Domain\Committees\CommitteeId;
use Francken\Domain\Members\Email;
use Broadway\Serializer\SerializableInterface;
use BroadwaySerialization\Serialization\Serializable;

final class CommitteeEmailChanged implements SerializableInterface
{
    use Serializable;

    private $committeeId;
    private $email;

    public function __construct(CommitteeId $committeeId, Email $email = null)
    {
        $this->committeeId = (string)$committeeId;
        $this->email = (string)$email;
    }

    public function committeeId() : CommitteeId
    {
        return new CommitteeId($this->committeeId);
    }

    public function email()
    {
        return $this->email ? new Email($this->email) : null;
    }
}
