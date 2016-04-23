<?php

namespace Francken\Domain\Members\Registration\Events;

use Broadway\Serializer\SerializableInterface;
use Francken\Domain\Base\Serializable;
use Francken\Domain\Members\Registration\RegistrationRequestId;
use Francken\Domain\Members\Person;
use Francken\Domain\Members\StudyDetails;

final class RegistrationRequestSubmitted implements SerializableInterface
{
    use Serializable;

    private $id;
    private $requestee;
    private $studentNumber;
    private $studyDetails;

    public function __construct(RegistrationRequestId $id, Person $requestee, StudyDetails $studyDetails)
    {
        $this->id = $id;
        $this->requestee = $requestee;
        $this->studyDetails = $studyDetails;
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
        return $this->studyDetails->studentNumber();
    }

    public function study() : string
    {
        return $this->studyDetails->study();
    }

    protected static function deserializationCallbacks()
    {
        return [
            'id' => [RegistrationRequestId::class, 'deserialize'],
            // 'requestee' => [Person::class, 'deserialize']
        ];
    }
}
