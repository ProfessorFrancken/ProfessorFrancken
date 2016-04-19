<?php

namespace Francken\Domain\Members;

final class Fullname {

    private $firstname;
    private $surname;
    private $middlename;

    public function __construct(
        string $firstname,
        string $middlename = null,
        string $surname
    )
    {
        $this->firstname = $firstname;
        $this->surname = $surname;
        $this->middlename = $middlename;
    }

    public function fullname() : string
    {
        return implode(' ', [
            $this->firstname,
            $this->middlename,
            $this->surname
        ]);
    }

    public function firstname() : string
    {
        return $this->firstname;
    }

    public function middlename() : string
    {
        return $this->middlename;
    }

    public function surname() : string
    {
        return $this->surname;
    }
}