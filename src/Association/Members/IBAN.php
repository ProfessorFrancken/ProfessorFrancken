<?php

declare(strict_types=1);

namespace Francken\Association\Members;

use CMPayments\IBAN as CMPayments_IBAN;

final class IBAN
{
    private $iban;

    public function __construct(string $iban)
    {
        $this->iban = new CMPayments_IBAN($iban);
    }

    public function __toString() : string
    {
        return $this->iban->format();
    }
}
