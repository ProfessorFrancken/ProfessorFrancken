<?php

declare(strict_types=1);

namespace Francken\Domain\Members\Registration\Events;

use Broadway\Serializer\Serializable as SerializableInterface;
use Francken\Domain\Serializable;
use Francken\Domain\Members\Registration\RegistrationRequestId;
use Francken\Domain\Members\StudyDetails;
use Francken\Domain\Members\ContactInfo;
use Francken\Domain\Members\FullName;
use Francken\Domain\Members\Address;
use Francken\Domain\Members\Gender;
use Francken\Domain\Members\Email;
use DateTimeImmutable;

final class RegistrationRequestSubmitted implements SerializableInterface
{
    use Serializable;

    private $id;
    private $fullName;
    private $gender;
    private $birthdate;
    private $contact;
    private $studyDetails;

    public function __construct(
        RegistrationRequestId $id,
        FullName $fullName,
        Gender $gender,
        DateTimeImmutable $birthdate,
        ContactInfo $contact,
        StudyDetails $studyDetails
    ) {
        $this->id = $id;
        $this->fullName = $fullName;
        $this->gender = $gender;
        $this->birthdate = $birthdate;
        $this->contact = $contact;
        $this->studyDetails = $studyDetails;
    }

    public function registrationRequestId() : RegistrationRequestId
    {
        return $this->id;
    }

    public function fullName() : FullName
    {
        return $this->fullName;
    }

    public function studentNumber() : string
    {
        return $this->studyDetails->studentNumber();
    }

    public function studies() : array
    {
        return $this->studyDetails->studies();
    }


    public function email() : Email
    {
        return $this->contact->email();
    }

    public function address() : Address
    {
        return $this->contact->address();
    }

    public function birthdate() : DateTimeImmutable
    {
        return $this->birthdate;
    }

    public function gender() : Gender
    {
        return $this->gender;
    }

    protected static function deserializationCallbacks()
    {
        return [
            'id' => [RegistrationRequestId::class, 'deserialize'],
            'fullName' => [FullName::class, 'deserialize'],
            'gender' => [Gender::class, 'deserialize'],
            'birthdate' => function ($value) {
                if ($value instanceof \DateTimeImmutable) {
                    return $value;
                }
                return \DateTimeImmutable::createFromFormat('Y-m-d H:i:s.u', $value['date']);
            },
            'contact' => [ContactInfo::class, 'deserialize'],
            'studyDetails' => [StudyDetails::class, 'deserialize']
        ];
    }
}
