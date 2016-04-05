<?php

namespace Francken\Activities\Events;

use Francken\Activities\ActivityId;

final class ActivityCategorized extends ActivityEvent
{
    protected $category;

    public function __construct(ActivityId $id, $category)
    {
        parent::__construct($id);
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
        return ['id' => [ActivityId::class, 'deserialize']];
    }
}
