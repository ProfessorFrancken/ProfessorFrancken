<?php

declare(strict_types=1);

namespace Francken\Association\Members;

use Webmozart\Assert\Assert;

final class PaymentInfo
{
    private $iban;
    private $payment_method;
    private $free_membership = false;

    public function __construct(string $iban, string $payment_method, bool $free_membership)
    {
        Assert::oneOf($payment_method, [
            'Afschrijven',
            'Contant',
            'Non-actief',
            'Niet'
        ]);

        $this->iban = $iban;
        $this->payment_method = $payment_method;
        $this->free_membership = $free_membership;
    }

    public function iban() : string
    {
        // For privacy reasons we mask the member's iban account number
        return substr_replace($this->iban, 'XXXX-XXXX-XXXX-XXX', 0, 15);
    }

    public function paymentMethod() : string
    {
        return $this->payment_method;
    }

    public function freeMembership() : bool
    {
        return $this->free_membership;
    }

    public static function fromDb($member)
    {
        return new self(
            $member->rekeningnummer,
            $member->streeplijst,
            (bool)$member->gratis_lidmaatschap
        );
    }
}
