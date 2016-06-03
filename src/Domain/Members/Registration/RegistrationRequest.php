<?php

namespace Francken\Domain\Members\Registration;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Francken\Domain\Members\Registration\Events\RegistrationRequestSubmitted;
use Francken\Domain\Members\Registration\RegistrationRequestId;
use Francken\Domain\Members\FullName;
use Francken\Domain\Members\StudyDetails;
use Francken\Domain\Members\Gender;
use Francken\Domain\Members\ContactInfo;
use Francken\Domain\Members\PaymentInfo;
use DateTimeImmutable;

final class RegistrationRequest extends EventSourcedAggregateRoot
{
    private $id;

    public static function submit(
        RegistrationRequestId $id,
        FullName $fullName,
        Gender $gender,
        DateTimeImmutable $birthdate,
        ContactInfo $contact,
        PaymentInfo $paymentInfo,
        StudyDetails $studyDetails
    ) : RegistrationRequest
    {
        $request = new RegistrationRequest;

        $request->apply(
            new RegistrationRequestSubmitted(
                $id,
                $fullName,
                $gender,
                $birthdate,
                $contact,
                $paymentInfo,
                $studyDetails
            )
        );

        return $request;
    }

    public function getAggregateRootId()
    {
        return $this->id;
    }

    protected function applyRegistrationRequestSubmitted(RegistrationRequestSubmitted $event)
    {
        $this->id = $event->registrationRequestId();
    }
}
