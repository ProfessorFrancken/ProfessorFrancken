<?php

namespace Francken\Application\Members\Registration;

use Illuminate\Http\Request;
use Francken\Application\Command;
use DateTimeImmutable;

use Francken\Domain\Members\StudyDetails;
use Francken\Domain\Members\ContactInfo;
use Francken\Domain\Members\PaymentInfo;
use Francken\Domain\Members\FullName;
use Francken\Domain\Members\Address;
use Francken\Domain\Members\Gender;
use Francken\Domain\Members\Email;
use Francken\Domain\Members\Registration\RegistrationRequest;
use Francken\Domain\Members\Registration\RegistrationRequestId;
use Francken\Domain\Members\Registration\RegistrationRequestRepository as Repository;

final class SubmitRegistrationRequest extends Command {

    private $id;
    private $name;
    private $birthdate;
    private $gender;
    private $study;
    private $contactInfo;
    private $paymentInfo;

    public function __construct(
        RegistrationRequestId $id,
        FullName $name,
        DateTimeImmutable $birthdate,
        Gender $gender,
        StudyDetails $study,
        ContactInfo $contactInfo,
        PaymentInfo $paymentInfo
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->birthdate = $birthdate;
        $this->gender = $gender;
        $this->study = $study;
        $this->contactInfo = $contactInfo;
        $this->paymentInfo = $paymentInfo;
    }

    // handle a [Membership Application]
    public function handle(Repository $repo)
    {
        $registrationRequest = RegistrationRequest::submit(
            $this->id,
            $this->name,
            $this->gender,
            $this->birthdate,
            $this->contactInfo,
            $this->paymentInfo,
            $this->study
        );

        $repo->save($registrationRequest);
    }

    public static function fromRequest(Request $request)
    {
        $name = new Fullname(
            $request->input('firstname'),
            $request->input('middlename'),
            $request->input('surname')
        );

        $birthdate = DateTimeImmutable::createFromFormat(
            'Y-m-d',
            $request->input('birthdate')
        );

        $gender = Gender::fromString(
            $request->input('gender')
        );


        $studyDetails = new StudyDetails(
            $request->input('study'),
            DateTimeImmutable::createFromFormat(
                'Y-m',
                $request->input('starting-date-study')
            ),
            $request->input('student-number')
        );

        $contactOptions = [];

        return new SubmitRegistrationRequest(
            RegistrationRequestId::generate(),
            $name,
            $birthdate,
            $gender,
            $studyDetails,
            $contactOptions
        );
    }
}