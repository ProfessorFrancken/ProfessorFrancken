<?php

declare(strict_types=1);

namespace Francken\Tests\Association\Members;

use Francken\Association\Members\PaymentDetails;
use PHPUnit\Framework\TestCase;

class PaymentDetailsTest extends TestCase
{
    /** @test */
    public function a_member_pays_for_a_membership() : void
    {
        $paymentDetails = new PaymentDetails(
            'NL91 ABNA 0417 1643 00'
        );

        $this->assertEquals(
            'NL91 ABNA 0417 1643 00',
            $paymentDetails->iban()
        );
        $this->assertEquals(
            'XXXX-XXXX-XXXX-1643-00',
            $paymentDetails->maskediban()
        );

        $this->assertFalse($paymentDetails->freeMembership());
        $this->assertEquals('Contant', $paymentDetails->paymentMethod());
    }

    /**
     * Since some international students don't have an iban when they register
     * we will allow omitting their iban
     *
     * @test
     */
    public function a_iban_can_be_omitted() : void
    {
        $paymentDetails = new PaymentDetails(null);

        $this->assertNull($paymentDetails->iban());
        $this->assertNull($paymentDetails->maskediban());
    }
}
