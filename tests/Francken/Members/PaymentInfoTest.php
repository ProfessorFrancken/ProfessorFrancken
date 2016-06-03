<?php

namespace Tests\Francken\Domain\Members;

use Francken\Domain\Members\PaymentInfo;
use Tests\SetupReconstitution;

class PaymentInfoTest extends \PHPUnit_Framework_TestCase
{
    use SetupReconstitution;

    /** @test */
    public function it_is_serializable()
    {
        $paymentInfo = new PaymentInfo(
            true,
            true
        );

        $this->assertEquals(
            $paymentInfo,
            PaymentInfo::deserialize($paymentInfo->serialize())
        );
    }
}
