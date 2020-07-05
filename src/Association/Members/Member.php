<?php

declare(strict_types=1);

namespace Francken\Association\Members;

use DateTimeImmutable;
use Francken\Association\Members\Students\Student;
use Illuminate\Support\Carbon;

final class Member
{
    private $member;

    public function __construct($member)
    {
        $this->member = $member;
    }

    public function fullName(): string
    {
        return implode(' ', array_filter([
            $this->member->voornaam, $this->member->tussenvoegsel, $this->member->achternaam
        ]));
    }

    public function email() : string
    {
        return $this->member->emailadres;
    }

    public function phoneNumber() : string
    {
        return $this->member->telefoonnummer_mobiel;
    }

    public function iban() : IBAN
    {
        return new IBAN($this->member->rekeningnummer);
    }

    public function birthDate() : DateTimeImmutable
    {
        return new DateTimeImmutable($this->member->geboortedatum);
    }

    public function startMembership() : Carbon
    {
        return new Carbon($this->member->start_lidmaatschap);
    }

    public function student() : Student
    {
        return Student::fromDb($this->member);
    }

    public function nnvNumber() : ?string
    {
        return $this->member->nnvnummer;
    }

    public function address() : Address
    {
        return new Address(
            $this->member->plaats,
            $this->member->adres,
            $this->member->postcode,
            $this->member->land
        );
    }

    public function receivesFranckenVrij() : bool
    {
        return (bool) $this->member->mailinglist_franckenvrij;
    }

    public function receivesBiWeeklyMailing() : bool
    {
        return (bool) $this->member->mailinglist_email;
    }

    public function paymentDetails() : PaymentDetails
    {
        return PaymentDetails::fromDb($this->member);
    }
}
