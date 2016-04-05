<?php

namespace Francken\Domain\Activities\Events;

use Broadway\Serializer\SerializableInterface;
use Francken\Domain\Base\Serializable;
use Francken\Domain\Activities\ActivityId;

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
        return ['id' => [ActivityId::class, 'deserialize']];
    }
}
