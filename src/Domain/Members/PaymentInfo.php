<?php

declare(strict_types=1);

namespace Francken\Domain\Members;

use Broadway\Serializer\SerializableInterface;
use Francken\Domain\DomainException;
use Francken\Domain\Serializable;
use Francken\Domain\Members;

final class PaymentInfo implements SerializableInterface
{
    use Serializable;

    private $payForMembership;
    private $payForFoodAndDrinks;
    private $iban;

    public function __construct(bool $payForMembership, bool $payForFoodAndDrinks, string $iban = null)
    {
        // A member must indicate that he or she is paying for the membership
        if (! $payForMembership) {
            throw new MemberMustPayForMembership;
        }

        $this->payForMembership = $payForMembership;
        $this->payForFoodAndDrinks = $payForFoodAndDrinks;
        $this->iban = $iban;
    }

    public function payForMembership() : bool
    {
        return $this->payForMembership;
    }

    public function payForFoodAndDrinks() : bool
    {
        return $this->payForFoodAndDrinks;
    }

    public function iban() : string
    {
        return $this->iban;
    }
}

final class MemberMustPayForMembership extends DomainException
{
}
