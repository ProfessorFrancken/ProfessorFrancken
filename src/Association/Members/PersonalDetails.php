<?php

declare(strict_types=1);

namespace Francken\Association\Members;

final class PersonalDetails
{
    private Fullname $fullname;
    private string $initials;
    private Gender $gender;
    private Birthdate $birthdate;
    private string $nationality;
    private bool $has_dutch_diploma;

    public function __construct(
        Fullname $fullname,
        string $initials,
        Gender $gender,
        Birthdate $birthdate,
        string $nationality,
        bool $has_dutch_diploma
    ) {
        $this->fullname = $fullname;
        $this->initials = $initials;
        $this->gender = $gender;
        $this->birthdate = $birthdate;
        $this->nationality = $nationality;
        $this->has_dutch_diploma = $has_dutch_diploma;
    }

    public function fullname() : Fullname
    {
        return $this->fullname;
    }

    public function initials() : string
    {
        return $this->initials;
    }

    public function gender() : Gender
    {
        return $this->gender;
    }

    public function birthdate() : Birthdate
    {
        return $this->birthdate;
    }

    public function nationality() : string
    {
        return $this->nationality;
    }

    public function hasDutchDiploma() : bool
    {
        return $this->has_dutch_diploma;
    }
}
