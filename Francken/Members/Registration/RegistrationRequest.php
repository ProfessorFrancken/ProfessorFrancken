<?php

namespace Francken\Members\Registration;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Francken\Members\Registration\Events\RegistrationRequestSubmitted;
use Francken\Members\Registration\RegistrationRequestId;
use Francken\Members\Person;

final class RegistrationRequest extends EventSourcedAggregateRoot
{
    private $id;

    public static function submit(RegistrationRequestId $id, Person $requestee, string $studentNumber, string $study) : RegistrationRequest
    {
        $request = new RegistrationRequest;

        $request->apply(
            new RegistrationRequestSubmitted(
                $id,
                $requestee,
                $studentNumber,
                $study
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
