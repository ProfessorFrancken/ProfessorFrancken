<?php

declare(strict_types=1);

namespace Francken\Association\Members;

final class StudyDetails
{
    private $studentNumber;
    private $studies;

    public function __construct(
        string $studentNumber,
        Study ...$studies
    ) {
        $this->studentNumber = $studentNumber;
        $this->studies = $studies;
    }

    public function studentNumber() : string
    {
        return $this->studentNumber;
    }

    public function studies() : array
    {
        return $this->studies;
    }
}
