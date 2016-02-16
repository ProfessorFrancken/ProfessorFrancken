<?php

namespace Francken\Activities\Events;

use Broadway\Serializer\SerializableInterface;
use BroadwaySerialization\Serialization\Serializable;

use Francken\Activities\ActivityId;
use Francken\Activities\Location;
use DateTime;

final class ActivityPlanned implements SerializableInterface
{
    use Serializable;

    private $id;
    private $name;
    private $description;
    private $time;
    private $location;
    private $type;

    public function __construct(ActivityId $id, $name, $description, DateTime $time, Location $location, $type)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->time = $time;
        $this->location = $location;
        $this->type = $type;
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