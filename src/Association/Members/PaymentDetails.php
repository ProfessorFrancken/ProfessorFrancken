<?php

declare(strict_types=1);

namespace Francken\Association\Members;

use Francken\Association\LegacyMember;

final class PaymentDetails
{
    private ?string $iban = null;

    private ?string $bic = null;

    private bool $deduct_additional_costs = false;

    /**
     * In the future we will also store the bic code, but as that would require
     * running a migration on our old database we will omit it for now
     */
    public function __construct(
        ?string $iban,
        ?string $bic = null,
        bool $deductAdditionalCosts = false
    ) {
        $this->iban = $iban;
        $this->bic = $bic;
        $this->deduct_additional_costs = $deductAdditionalCosts;
    }

    public function iban() : ?string
    {
        return $this->iban;
    }

    public function bic() : ?string
    {
        return $this->bic;
    }

    public function maskedIban() : ?string
    {
        if ($this->iban === null) {
            return null;
        }

        // For privacy reasons we mask the member's iban account number
        return str_replace(
            ' ',
            '-',
            substr_replace($this->iban, 'XXXX-XXXX-XXXX-XX', 0, 17)
        );
    }

    public function paymentMethod() : string
    {
        return $this->deduct_additional_costs ? 'Afschrijven' : 'Contant';
    }

    public function freeMembership() : bool
    {
        return false;
    }

    public function deductAdditionalCosts() : bool
    {
        return $this->deduct_additional_costs;
    }

    public static function fromDb(LegacyMember $member) : self
    {
        $deductAdditionalCosts = $member->streeplijst === 'Afschrijven';

        return new self($member->rekeningnummer, null, $deductAdditionalCosts);
    }
}
