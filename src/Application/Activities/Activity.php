<?php

declare(strict_types=1);

namespace Francken\Application\Activities;

use Francken\Domain\Serializable;
use Broadway\ReadModel\Identifiable as ReadModelInterface;
use Broadway\Serializer\Serializable as SerializableInterface;
use Francken\Domain\Activities\ActivityId;
use Francken\Domain\Activities\Schedule;
use Francken\Domain\Activities\Location;

final class Activity implements ReadModelInterface, SerializableInterface
{
    use Serializable;

    private $id;
    private $name;
    private $published;
    private $category;

    private $schedule_start;
    private $schedule_end;

    private $location_name;
    private $location_postal_code;
    private $location_street_name;
    private $location_street_number;

    private $participants;

    public function __construct(
        ActivityId $id,
        string $name,
        bool $published,
        string $category,
        Schedule $schedule,
        Location $location,
        array $participants
    ) {
        $this->id = (string)$id;
        $this->name = $name;
        $this->published = $published;
        $this->category = $category;
        $this->participants = $participants;
        $this->extractScheduleAndLocation($schedule, $location);
    }

    public function getId() : string
    {
        return $this->id;
    }

    public function activityId() : ActivityId
    {
        return new ActivityId($this->id);
    }

    public function name() : string
    {
        return $this->name;
    }

    public function published() : bool
    {
        return $this->published;
    }

    public function category() : string
    {
        return $this->category;
    }

    public function schedule() : Schedule
    {
        return Schedule::deserialize([
            'startTime' => $this->schedule_start,
            'endTime' => $this->schedule_end
        ]);
    }

    public function location() : Location
    {
        return Location::deserialize([
            'name' => $this->location_name,
            'postalCode' => $this->location_postal_code,
            'streetName' => $this->location_street_name,
            'streetNumber' => $this->location_street_number
        ]);
    }

    public function participants() : array
    {
        return $this->participants;
    }

    private function extractScheduleAndLocation(Schedule $schedule, Location $location)
    {
        $serialized_schedule = $schedule->serialize();
        $this->schedule_start = $serialized_schedule['startTime'];
        $this->schedule_end = $serialized_schedule['endTime'];

        $serialized_location = $location->serialize();
        $this->location_name = $serialized_location['name'];
        $this->location_postal_code = $serialized_location['postalCode'];
        $this->location_street_name = $serialized_location['streetName'];
        $this->location_street_number = $serialized_location['streetNumber'];
    }
}
