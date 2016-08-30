<?php

declare(strict_types=1);

namespace Francken\Domain\Activities\Events;

use Francken\Domain\Activities\ActivityId;
use Francken\Domain\Activities\Location;
use Francken\Domain\Activities\Schedule;
use DateTimeImmutable;

final class ActivityPlanned extends ActivityEvent
{

    protected $name;
    protected $description;
    protected $startTime;
    protected $endTime;
    protected $schedule;
    protected $location;
    protected $category;

    public function __construct(ActivityId $id, $name, $description, Schedule $schedule, Location $location, $category)
    {
        parent::__construct($id);

        $this->name = $name;
        $this->description = $description;
        $this->location = $location;
        $this->category = $category;
        $this->startTime = $schedule->startTime();
        $this->endTime = $schedule->endTime();
        $this->schedule = $schedule;
    }

    public function name()
    {
        return $this->name;
    }

    public function description()
    {
        return $this->description;
    }

    public function schedule()
    {
        return $this->schedule;
    }

    public function startTime()
    {
        return $this->startTime;
    }

    public function location()
    {
        return $this->location;
    }

    public function category()
    {
        return $this->category;
    }
}
