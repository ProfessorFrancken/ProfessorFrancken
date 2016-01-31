<?php

namespace Francken\Committees\Events;

use Broadway\Serializer\SerializableInterface;

abstract class CommitteeEvent implements SerializableInterface
{
    private $committeeId;

    public function __construct($committeeId)
    {
        $this->committeeId = $committeeId;
    }

    public static function deserialize(array $data)
    {
        return new static($data['committeeId']);
    }

    public function serialize()
    {
        return [
            'committeeId' => (string) $this->committeeId
        ];
    }
}


