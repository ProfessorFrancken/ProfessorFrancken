<?php

declare(strict_types=1);

namespace Tests\Francken\Domain\Members;

use Francken\Association\Members\PaymentDetails;

class PaymentDetailsTest extends \PHPUnit\Framework\TestCase
{
    /** @test */
    public function a_member_pays_for_a_membership() : void
    {
        $paymentDetails = new PaymentDetails('NL91 ABNA 0417 1643 00');

        $this->assertEquals(
            'NL91 ABNA 0417 1643 00',
            $paymentDetails->iban()
        );
    }
}
