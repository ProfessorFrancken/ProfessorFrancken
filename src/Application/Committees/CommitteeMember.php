<?php

declare(strict_types=1);

namespace Francken\Application\Committees;

final class CommitteeMember
{
    private $firstname;
    private $lastname;
    private $id;

    public function __construct($id, string $firstname, string $lastname)
    {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
    }

    public function id()
    {
        return $this->id;
    }

    public function fullName() : string
    {
        return $this->firstname . ' ' . $this->lastname;
    }
}
