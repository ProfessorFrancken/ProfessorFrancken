<?php

declare(strict_types=1);

namespace Tests\Francken\Domain\Members\Registration\Events;

use Francken\Tests\SetupReconstitution;
use Francken\Domain\Members\Registration\RegistrationRequestId;
use Francken\Domain\Members\Registration\Events\PaymentInfoProvided;
use Francken\Domain\Members\StudyDetails;
use Francken\Domain\Members\ContactInfo;
use Francken\Domain\Members\PaymentInfo;
use Francken\Domain\Members\FullName;
use Francken\Domain\Members\Address;
use Francken\Domain\Members\Gender;
use Francken\Domain\Members\Email;
use DateTimeImmutable;

class PaymentInfoProvidedTest extends \PHPUnit_Framework_TestCase
{
    use SetupReconstitution;

    /** @test */
    public function it_is_insttantiable()
    {
        $id = RegistrationRequestId::generate();
        $paymentInfo = new PaymentInfo(true, true);
        $event = new PaymentInfoProvided($id, $paymentInfo);

        $this->assertEquals($paymentInfo, $event->paymentInfo());
    }

    /** @test */
    public function it_is_serializable()
    {
        $id = RegistrationRequestId::generate();
        $paymentInfo = new PaymentInfo(true, true);
        $event = new PaymentInfoProvided($id, $paymentInfo);

        $this->assertEquals(
            $event,
            PaymentInfoProvided::deserialize($event->serialize())
        );
    }
}
