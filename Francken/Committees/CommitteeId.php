<?php

namespace Francken\Committees;

use Assert\Assertion as Assert;

final class CommitteeId
{
    private $committeeId;

    /**
     * @param string $committeeId
     */
    public function __construct($committeeId)
    {
        Assert::string($committeeId);
        Assert::uuid($committeeId);

        $this->committeeId = $committeeId;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->committeeId;
    }
}

