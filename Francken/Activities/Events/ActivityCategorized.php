<?php

namespace Francken\Activities\Events;

use Broadway\Serializer\SerializableInterface;
use BroadwaySerialization\Serialization\Serializable;

use Francken\Activities\ActivityId;

final class ActivityCategorized implements SerializableInterface
{
    use Serializable;

    private $id;
    private $category;

    public function __construct(ActivityId $id, $category)
    {
        $this->id = $id;
        $this->category = $category;
    }

    public function activityId()
    {
        return $this->id;
    }

    public function category()
    {
        return $this->category;
    }

    protected static function deserializationCallbacks()
    {
        return [];
    }
}
