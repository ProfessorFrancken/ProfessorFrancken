<?php

namespace Francken\Activities\Events;

use Broadway\Serializer\SerializableInterface;

use Francken\Activities\ActivityId;
use Francken\Activities\Location;
use DateTime;

final class ActivityPlanned implements SerializableInterface
{
    private $id;
    private $name;
    private $descriptions;
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

    public static function deserialize(array $data)
    {
        return new static($data['activityId']);
    }

    public function serialize()
    {
        return [
            'activityId' => (string) $this->activityId
        ];
    }

}