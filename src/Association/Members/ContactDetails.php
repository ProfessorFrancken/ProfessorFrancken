<?php

declare(strict_types=1);

namespace Francken\Association\Members;

final class ContactDetails
{
    private $email;
    private $address;

    public function __construct(Email $email, Address $address)
    {
        $this->email = $email;
        $this->address = $address;
    }

    public function email() : Email
    {
        return $this->email;
    }

    public function address() : Address
    {
        return $this->address;
    }
}
