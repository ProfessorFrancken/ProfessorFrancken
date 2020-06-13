<?php

declare(strict_types=1);

namespace Tests\Francken\Domain\Members;

use Francken\Association\Members\PaymentDetails;

class PaymentDetailsTest extends \PHPUnit\Framework\TestCase
{
    /** @test */
    public function a_member_pays_for_a_membership() : void
    {
        $paymentDetails = new PaymentDetails(
            'NL91 ABNA 0417 1643 00', 'Afschrijven', false
        );

        $this->assertEquals(
            'NL91 ABNA 0417 1643 00',
            $paymentDetails->iban()
        );
        $this->assertEquals(
            'XXXX-XXXX-XXXX-XX43-00',
            $paymentDetails->maskediban()
        );

        $this->assertFalse($paymentDetails->freeMembership());
        $this->assertEquals('Afschrijven', $paymentDetails->paymentMethod());
    }

    /**
     * Since some international students don't have an iban when they register
     * we will allow omitting their iban
     *
     * @test
     */
    public function a_iban_can_be_omitted() : void
    {
        $paymentDetails = new PaymentDetails(
null, 'Afschrijven', false
        );

        $this->assertNull($paymentDetails->iban());
        $this->assertNull($paymentDetails->maskediban());
    }
}
