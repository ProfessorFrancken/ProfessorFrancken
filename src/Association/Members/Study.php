<?php

declare(strict_types=1);

namespace Francken\Association\Members;

use DateTimeImmutable;

final class Study
{
    private $study;
    private $startDate;
    private $graduationDate;

    public function __construct(
        string $study,
        DateTimeImmutable $startDate,
        ?DateTimeImmutable $graduationDate = null
    ) {
        $this->study = $study;
        $this->startDate = $startDate;
        $this->graduationDate = $graduationDate;
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
}
