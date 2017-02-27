<?php

declare(strict_types=1);

namespace Francken\Domain\Members;

use Broadway\Serializer\SerializableInterface;
use DateTimeImmutable;
use Francken\Domain\Serializable;

final class StudyDetails implements SerializableInterface
{
    use Serializable;

    private $study;
    private $startDate;
    private $studentNumber;

    public function __construct(
        string $study,
        DateTimeImmutable $studyStartDate,
        string $studentNumber
    ) {
        $this->study = $study;
        $this->startDate = $studyStartDate;
        $this->studentNumber = $studentNumber;
    }

    public function study() : string
    {
        return $this->study;
    }

    public function startDate() : DateTimeImmutable
    {
        return $this->startDate;
    }

    public function studentNumber() : string
    {
        return $this->studentNumber;
    }
}
