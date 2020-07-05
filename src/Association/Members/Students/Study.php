<?php

declare(strict_types=1);

namespace Francken\Association\Members\Students;

use DateTimeImmutable;

final class Study
{
    private string $name;
    private DateTimeImmutable $startDate;
    private ?DateTimeImmutable $endDate = null;

    public function __construct(
        string $name,
        DateTimeImmutable $startDate,
        DateTimeImmutable $endDate = null
    ) {
        $this->name = $name;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function __toString() : string
    {
        return $this->name;
    }

    public function startYear() : string
    {
        return $this->startDate->format('Y');
    }

    public function endYear() : string
    {
        return $this->endDate !== null
            ? $this->endDate->format('Y')
            : "current";
    }
}
