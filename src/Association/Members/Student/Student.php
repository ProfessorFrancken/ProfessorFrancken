<?php

declare(strict_types=1);

namespace Francken\Association\Members\Students;

use DateTimeImmutable;

final class Student
{
    private $studentNumber;
    private $studies;

    public function __construct(StudentNumber $studentNumber, array $studies)
    {
        $this->studentNumber = $studentNumber;
        $this->studies = $studies;
    }

    public function studentNumber() : StudentNumber
    {
        return $this->studentNumber;
    }

    public function studies() : array
    {
        return $this->studies;
    }

    public function currentStudy() : Study
    {
        return $this->studies[0];
    }

    public static function fromDb($member)
    {
        return new Student(
            new StudentNumber($member->studentnummer),
            [
                new Study(
                    $member->studierichting,
                    DateTimeImmutable::createFromFormat(
                        'Y-m-d',
                        $member->jaar_van_inschrijving.'-09-01'
                    )
                )
            ]
        );
    }
}

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
