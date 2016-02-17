<?php

namespace Francken\Activities\Events;

use Broadway\Serializer\SerializableInterface;
use BroadwaySerialization\Serialization\Serializable;

use Francken\Activities\ActivityId;

abstract class ActivityEvent implements SerializableInterface
{
    use Serializable;

    protected $id;

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