<?php

namespace Francken\Domain\Members\Registration\Events;

use Broadway\Serializer\SerializableInterface;
use Francken\Domain\Base\Serializable;
use Francken\Domain\Members\PaymentInfo;
use Francken\Domain\Members\Registration\RegistrationRequestId;

final class PaymentInfoProvided implements SerializableInterface
{
    use Serializable;

    private $id;
    private $paysForMembership = true;
    private $paysForFoodAndDrinks = false;

    public function __construct(
        RegistrationRequestId $id,
        PaymentInfo $payment
    ) {
        $this->id = (string)$id;
        $this->paysForMembership = $payment->payForMembership();
        $this->paysForFoodAndDrinks = $payment->payForFoodAndDrinks();
    }

    public function registrationRequestId() : RegistrationRequestId
    {
        return new RegistrationRequestId($this->id);
    }

    public function paymentInfo()
    {
        return new PaymentInfo(
            $this->paysForMembership,
            $this->paysForFoodAndDrinks
        );
    }
}
