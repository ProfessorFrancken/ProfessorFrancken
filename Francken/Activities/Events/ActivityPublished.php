<?php

namespace Francken\Activities\Events;

use Broadway\Serializer\SerializableInterface;
use BroadwaySerialization\Serialization\Serializable;

use Francken\Activities\ActivityId;

final class ActivityPublished implements SerializableInterface
{
    use Serializable;

    private $id;

    public function __construct(ActivityId $id)
    {
        $this->id = $id;
    }

    public function activityId()
    {
        return $this->id;
    }

    protected static function deserializationCallbacks()
    {
        return [];
    }
}