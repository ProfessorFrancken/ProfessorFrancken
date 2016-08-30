<?php

declare(strict_types=1);

namespace Francken\Domain\Members\Registration;

use DateTimeImmutable;
use Francken\Domain\AggregateRoot;
use Francken\Domain\Members\ContactInfo;
use Francken\Domain\Members\FullName;
use Francken\Domain\Members\Gender;
use Francken\Domain\Members\PaymentInfo;
use Francken\Domain\Members\Registration\Events\PaymentInfoProvided;
use Francken\Domain\Members\Registration\Events\RegistrationRequestSubmitted;
use Francken\Domain\Members\Registration\RegistrationRequestId;
use Francken\Domain\Members\StudyDetails;

final class RegistrationRequest extends AggregateRoot
{
    private $id;

    public static function submit(
        RegistrationRequestId $id,
        FullName $fullName,
        Gender $gender,
        DateTimeImmutable $birthdate,
        ContactInfo $contact,
        StudyDetails $studyDetails,
        PaymentInfo $paymentInfo = null
    ) : RegistrationRequest {
        $request = new RegistrationRequest;

        $request->apply(
            new RegistrationRequestSubmitted(
                $id,
                $fullName,
                $gender,
                $birthdate,
                $contact,
                $studyDetails
            )
        );

        if (isset($paymentInfo)) {
            $request->providePaymentInfo($paymentInfo);
        }

        return $request;
    }

    public function getAggregateRootId()
    {
        return $this->id;
    }


    public function providePaymentInfo(PaymentInfo $paymentInfo)
    {
        $this->apply(
            new PaymentInfoProvided($this->id, $paymentInfo)
        );
    }

    protected function applyRegistrationRequestSubmitted(RegistrationRequestSubmitted $event)
    {
        $this->id = $event->registrationRequestId();
    }
}
