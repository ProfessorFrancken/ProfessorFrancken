<?php

declare(strict_types=1);

namespace Francken\Domain\Activities\Events;

use Broadway\Serializer\Serializable as SerializableInterface;
use Francken\Domain\Serializable;
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
