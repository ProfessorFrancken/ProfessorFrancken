<?php

declare(strict_types=1);

namespace Francken\Association\Members;

final class PaymentDetails
{
    private $iban;

    public function __construct(?string $iban)
    {
        $this->iban = $iban;
    }

    public function iban() : ?string
    {
        return $this->iban;
    }
}
