<?php

namespace Francken\Activities;

use Assert\Assertion as Assert;

final class ActivityId
{
    private $activityId;

    /**
     * @param string $activityId
     */
    public function __construct($activityId)
    {
        Assert::string($activityId);
        Assert::uuid($activityId);

        $this->activityId = $activityId;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->activityId;
    }
}
