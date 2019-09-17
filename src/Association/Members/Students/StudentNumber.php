<?php

declare(strict_types=1);

namespace Francken\Association\Members\Students;

final class StudentNumber
{
    private $studentNumber;

    public function __construct(string $number)
    {
        $this->studentNumber = $number;
    }

    public function __toString() : string
    {
        return $this->studentNumber;
    }
}
