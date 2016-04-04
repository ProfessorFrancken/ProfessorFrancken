<?php

namespace Francken\Members\Registration\Events;

use Broadway\Serializer\SerializableInterface;
use Francken\Base\Serializable;
use Francken\Members\Registration\RegistrationRequestId;
use Francken\Members\Person;

final class RegistrationRequestSubmitted implements SerializableInterface
{
    use Serializable;

    private $id;
    private $requestee;
    private $studentNumber;
    private $study;

    public function __construct(RegistrationRequestId $id, Person $requestee, string $studentNumber, string $study)
    {
        $this->id = $id;
        $this->requestee = $requestee;
        $this->studentNumber = $studentNumber;
        $this->study = $study;
    }

    public function registrationRequestId() : RegistrationRequestId
    {
        return $this->id;
    }

    public function requestee() : Person
    {
        return $this->requestee;
    }

    public function studentNumber() : string
    {
        return $this->studentNumber;
    }

    public function study() : string
    {
        return $this->study;
    }

    protected static function deserializationCallbacks()
    {
        return [
            'id' => [RegistrationRequestId::class, 'deserialize'],
            // 'requestee' => [Person::class, 'deserialize']
        ];
    }
}
