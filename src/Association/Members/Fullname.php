<?php

declare(strict_types=1);

namespace Francken\Association\Members;

use Webmozart\Assert\Assert;

final class Fullname
{
    private string $firstname;

    private string $surname;

    private function __construct(string $firstname, string $surname)
    {
        $this->firstname = $firstname;
        $this->surname = $surname;
    }

    public function firstname() : string
    {
        return $this->firstname;
    }

    public function surname() : string
    {
        return $this->surname;
    }

    public function toString() : string
    {
        return "{$this->firstname} {$this->surname}";
    }

    public static function fromFirstnameAndSurname(string $firstname, string $surname) : self
    {
        Assert::minLength($firstname, 1);
        Assert::minLength($surname, 1);

        return new self($firstname, $surname);
    }
}
