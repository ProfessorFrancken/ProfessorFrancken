<?php

declare(strict_types=1);

namespace Tests\Francken\Domain\Members;

use Francken\Domain\Members\MemberMustPayForMembership;
use Francken\Domain\Members\PaymentInfo;
use Francken\Tests\SetupReconstitution;

class PaymentInfoTest extends \PHPUnit\Framework\TestCase
{
    use SetupReconstitution;

    /** @test */
    public function a_member_pays_for_a_membership() : void
    {
        $paymentInfo = new PaymentInfo(
            true,
            false
        );

        $this->assertTrue($paymentInfo->payForMembership());
        $this->assertFalse($paymentInfo->payForFoodAndDrinks());
    }

    /** @test */
    public function a_member_can_pay_for_food_and_drinks() : void
    {
        $paymentInfo = new PaymentInfo(
            true,
            true
        );

        $this->assertTrue($paymentInfo->payForMembership());
        $this->assertTrue($paymentInfo->payForFoodAndDrinks());
    }

    /** @test */
    public function a_member_must_pay_for_a_membershipo() : void
    {
        $this->expectException(MemberMustPayForMembership::class);
        $paymentInfo = new PaymentInfo(
            false,
            false
        );
    }


    /** @test */
    public function it_is_serializable() : void
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
