<?php

declare(strict_types=1);

namespace Francken\Association\Members;

use DateTimeImmutable;
use Francken\Association\LegacyMember;
use Webmozart\Assert\Assert;

final class StudyDetails
{
    private string $studentNumber;

    /**
     * @var mixed[]
     */
    private array $studies = [];

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

    public static function fromDb(LegacyMember $member) : self
    {
        $yearOfRegistration = DateTimeImmutable::createFromFormat(
            'Y-m-d',
            ($member->jaar_van_inschrijving === '' ? 0 : $member->jaar_van_inschrijving) . '-09-01'
        );
        Assert::isInstanceOf($yearOfRegistration, DateTimeImmutable::class);

        return new self(
            $member->studentnummer ?? '',
            new Study(
                $member->studierichting ?? '',
                $yearOfRegistration
            )
        );
    }
}
