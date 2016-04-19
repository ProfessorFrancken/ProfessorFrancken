<?php

namespace Francken\Domain\Members;

use Francken\Domain\Members\ContactInfo;
use Francken\Domain\Members\FullName;
use Francken\Domain\Members\Email;
use Francken\Domain\Members\Address;
use DateTimeImmutable;

final class Person
{
    private $fullName;
    private $gender;
    private $birthdate;
    private $contact;

    const MALE = 'male';

    private function __construct(
        FullName $fullName,
        Gender $gender,
        DateTimeImmutable $birthdate,
        ContactInfo $contact
    ) {
        $this->fullName = $fullName;
        $this->gender = $gender;
        $this->birthdate = $birthdate;
        $this->contact = $contact;
    }

    public static function describe(
        FullName $fullName,
        Gender $gender,
        DateTimeImmutable $birthdate,
        ContactInfo $contact
    ) {
        $person = new Person(
            $fullName,
            $gender,
            $birthdate,
            $contact
        );

        return $person;
    }

    public function firstname() : string
    {
        return $this->fullName->firstname();
    }

    public function surname() : string
    {
        return $this->fullName->surname();
    }

    public function gender() : string
    {
        return (string )$this->gender;
    }
}
