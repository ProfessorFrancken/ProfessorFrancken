<?php

namespace Tests\Francken\Domain\Members;

use Francken\Domain\Members\PaymentInfo;
use Francken\Domain\Members\MemberMustPayForMembership;
use Tests\SetupReconstitution;

class PaymentInfoTest extends \PHPUnit_Framework_TestCase
{
    use SetupReconstitution;

    /** @test */
    function a_member_pays_for_a_membership()
    {
        $paymentInfo = new PaymentInfo(
            true,
            false
        );

        $this->assertTrue($paymentInfo->payForMembership());
        $this->assertFalse($paymentInfo->payForFoodAndDrinks());
    }

    /** @test */
    function a_member_can_pay_for_food_and_drinks()
    {
        $paymentInfo = new PaymentInfo(
            true,
            true
        );

        $this->assertTrue($paymentInfo->payForMembership());
        $this->assertTrue($paymentInfo->payForFoodAndDrinks());
    }

    /** @test */
    function a_member_must_pay_for_a_membershipo()
    {
        $this->expectException(MemberMustPayForMembership::class);
        $paymentInfo = new PaymentInfo(
            false,
            false
        );
    }


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
