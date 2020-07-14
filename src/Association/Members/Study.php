<?php

declare(strict_types=1);

namespace Francken\Association\Members;

use DateTimeImmutable;

final class Study
{
    private string $study;

    private DateTimeImmutable $startDate;

    private ?DateTimeImmutable $graduationDate = null;

    public function __construct(
        string $study,
        DateTimeImmutable $startDate,
        ?DateTimeImmutable $graduationDate = null
    ) {
        $this->study = $study;
        $this->startDate = $startDate;
        $this->graduationDate = $graduationDate;
    }

    public function __toString() : string
    {
        return $this->study;
    }

    public function study() : string
    {
        return $this->study;
    }

    public function startDate() : DateTimeImmutable
    {
        return $this->startDate;
    }

    public function graduationDate() : ?DateTimeImmutable
    {
        return $this->graduationDate;
    }

    public function startYear() : string
    {
        return $this->startDate->format('Y');
    }

    public function endYear() : string
    {
        return $this->graduationDate !== null
            ? $this->graduationDate->format('Y')
            : "current";
    }
}
