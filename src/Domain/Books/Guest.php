<?php

namespace Francken\Domain\Books;

use Francken\Domain\Members\Email;

class Guest
{
    private $name;
    private $email;

    public function __construct(string $name, Email $email)
    {
        $this->name = $name;
        $this->email = $email;
    }

    public function name() : string
    {
        return $this->name;
    }

    public function email() : Email
    {
        return $this->email;
    }
}
