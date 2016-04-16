<?php

namespace Francken\Domain\Activities\Events;

use Francken\Domain\Activities\ActivityId;
use Francken\Domain\Activities\Schedule;
use DateTimeImmutable;

final class ActivityRescheduled extends ActivityEvent
{
    protected $schedule;

    public function __construct(ActivityId $id, Schedule $schedule)
    {
        parent::__construct($id);

        $this->schedule = $schedule;
    }

    public function activityId()
    {
        return $this->id;
    }

    public function schedule()
    {
        return $this->schedule;
    }

    protected static function deserializationCallbacks()
    {
        return [
            'id' => [ActivityId::class, 'deserialize']
        ];
    }
}
