<?php

namespace Francken\Activities\Events;

use Francken\Activities\ActivityId;
use Francken\Activities\Location;
use DateTime;

final class ActivityPlanned extends ActivityEvent
{

    protected $name;
    protected $description;
    protected $time;
    protected $location;
    protected $category;

    public function __construct(ActivityId $id, $name, $description, DateTime $time, Location $location, $category)
    {
        parent::__construct($id);

        $this->name = $name;
        $this->description = $description;
        $this->time = $time;
        $this->location = $location;
        $this->category = $category;
    }

    public function name()
    {
        return $this->name;
    }

    public function description()
    {
        return $this->description;
    }

    public function time()
    {
        return $this->time;
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