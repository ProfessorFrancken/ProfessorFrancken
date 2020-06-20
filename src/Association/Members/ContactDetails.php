<?php

declare(strict_types=1);

namespace Francken\Association\Members;

final class ContactDetails
{
    private $email;
    private $address;
    private $phoneNumber;

    public function __construct(Email $email, ?Address $address, ?string $phoneNumber)
    {
        $this->email = $email;
        $this->address = $address;
        $this->phoneNumber = $phoneNumber;
    }

    public function email() : Email
    {
        return $this->email;
    }

    public function address() : ?Address
    {
        return $this->address;
    }

    public function phoneNumber()
    {
        return $this->phoneNumber;
    }
}