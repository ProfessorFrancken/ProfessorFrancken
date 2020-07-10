<?php

declare(strict_types=1);

namespace Francken\Association\Members\Students;

use DateTimeImmutable;
use Francken\Association\LegacyMember;
use Webmozart\Assert\Assert;

final class Student
{
    private StudentNumber $studentNumber;
    /**
     * @var mixed[]
     */
    private array $studies = [];

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

    public static function fromDb(LegacyMember $member) : self
    {
        $yearOfRegistration = DateTimeImmutable::createFromFormat(
            'Y-m-d',
            $member->jaar_van_inschrijving . '-09-01'
        );
        Assert::isInstanceOf($yearOfRegistration, DateTimeImmutable::class);


        return new self(
            new StudentNumber($member->studentnummer),
            [
                new Study(
                    $member->studierichting,
                    $yearOfRegistration
                )
            ]
        );
    }
}
