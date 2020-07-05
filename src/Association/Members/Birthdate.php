<?php

declare(strict_types=1);

namespace Francken\Association\Members;

use DateTimeImmutable;
use InvalidArgumentException;
use Webmozart\Assert\Assert;

final class Birthdate
{
    private DateTimeImmutable $date;

    private function __construct(DateTimeImmutable $date)
    {
        $this->date = $date;
    }
   
    public function toString() : string
    {
        return $this->date->format('Y-m-d');
    }

    public function toDateTime() : DateTimeImmutable
    {
        return $this->date;
    }

    public function ageAt(DateTimeImmutable $time) : int
    {
        return $this->date->diff($time)->y;
    }

    public static function fromString(string $birthday) : self
    {
        $date = DateTimeImmutable::createFromFormat('!Y-m-d', $birthday);

        Assert::isInstanceOf($date, DateTimeImmutable::class);

        if ( ! $date) {
            throw new InvalidArgumentException("Given date was not in Y-m-d format");
        }

        return self::fromDateTime($date);
    }

    public static function fromDateTime(DateTimeImmutable $date) : self
    {
        $birthdate = DateTimeImmutable::createFromFormat('!Y-m-d', $date->format('Y-m-d'));

        Assert::isInstanceOf($birthdate, DateTimeImmutable::class);

        return new self($birthdate);
    }
}
