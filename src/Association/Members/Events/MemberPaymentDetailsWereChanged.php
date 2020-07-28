<?php

declare(strict_types=1);

namespace Francken\Association\Members\Events;

use Francken\Association\LegacyMember;
use Illuminate\Queue\SerializesModels;

final class MemberPaymentDetailsWereChanged
{
    use SerializesModels;

    private LegacyMember $member;
    private string $iban;
    private string $oldIban;
    private string $consumptionCounter;
    private string $oldConsumptionCounter;

    public function __construct(
        LegacyMember $member,
        string $iban,
        string $oldIban,
        string $consumptionCounter,
        string $oldConsumptionCounter
    ) {
        $this->member = $member;
        $this->iban = $iban;
        $this->oldIban = $oldIban;
        $this->consumptionCounter = $consumptionCounter;
        $this->oldConsumptionCounter = $oldConsumptionCounter;
    }

    public function member() : LegacyMember
    {
        return $this->member;
    }

    public function iban() : string
    {
        return $this->iban;
    }

    public function oldIban() : string
    {
        return $this->oldIban;
    }

    public function consumptionCounter() : string
    {
        return $this->consumptionCounter;
    }

    public function oldConsumptionCounter() : string
    {
        return $this->oldConsumptionCounter;
    }
}
