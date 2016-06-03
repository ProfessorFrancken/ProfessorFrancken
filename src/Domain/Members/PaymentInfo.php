<?php

namespace Francken\Domain\Members;

use Francken\Domain\Members;
use Broadway\Serializer\SerializableInterface;
use Francken\Domain\Base\Serializable;

final class PaymentInfo implements SerializableInterface
{
    use Serializable;

    private $payForMembership;
    private $payForFoodAndDrinks;

    public function __construct(bool $payForMembership, bool $payForFoodAndDrinks)
    {
        $this->payForMembership = $payForMembership;
        $this->payForFoodAndDrinks = $payForFoodAndDrinks;
    }
}
