<?php

namespace Francken\Members;

use Francken\Members\ContactInfo;
use Francken\Members\Email;
use Francken\Members\Address;
use DateTimeImmutable;

final class Person
{
    private $firstname;
    private $middlename;
    private $surname;
    private $gender;
    private $birthdate;
    private $contact;

    const MALE = 'male';

    private function __construct(
        string $firstname,
        string $middlename,
        string $surname,
        string $gender,
        DateTimeImmutable $birthdate,
        ContactInfo $contact
    )
    {
        $this->firstname = $firstname;
        $this->middlename = $middlename;
        $this->surname = $surname;
        $this->gender = $gender;
        $this->birthdate = $birthdate;
        $this->contact = $contact;
    }

    public static function describe(
        string $firstname,
        string $middlename,
        string $surname,
        string $gender,
        DateTimeImmutable $birthdate,
        ContactInfo $contact
    )
    {
        $person = new Person(
            $firstname,
            $middlename,
            $surname,
            $gender,
            $birthdate,
            $contact
        );

        return $person;
    }

    public function firstname() : string
    {
        return $this->firstname;
    }

    public function surname() : string
    {
        return $this->surname;
    }

    public function gender() : string
    {
        return $this->gender;
    }
}