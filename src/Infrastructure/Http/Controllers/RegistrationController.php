<?php

declare(strict_types=1);

namespace Francken\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use Francken\Application\Members\Registration\SubmitRegistrationRequest;
use Francken\Domain\Members\Registration\RegistrationRequest;
use Francken\Domain\Members\Registration\RegistrationRequestId;
use Francken\Domain\Members\Registration\RegistrationRequestRepository as Repository;
use Francken\Domain\Members\StudyDetails;
use Francken\Domain\Members\ContactInfo;
use Francken\Domain\Members\PaymentInfo;
use Francken\Domain\Members\FullName;
use Francken\Domain\Members\Address;
use Francken\Domain\Members\Gender;
use Francken\Domain\Members\Email;
use DateTimeImmutable;

class RegistrationController extends Controller
{
    public function request()
    {
        return view('registration.request');
    }

    public function submitRequest(Request $request, Repository $repo)
    {
        // Gather all the given inputs and put them into value objects
        // that are needed by the SubmitRegistrationRequest command
        $name = $this->fullNameFrom($request);
        $birthdate = $this->birthdateFrom($request);
        $gender = $this->genderFrom($request);
        $studyDetails = $this->studyDetailsFrom($request);
        $contactInfo = $this->contactInfoFrom($request);
        $paymentInfo = $this->paymentInfoFrom($request);

        $command = new SubmitRegistrationRequest(
            RegistrationRequestId::generate(),
            $name,
            $birthdate,
            $gender,
            $studyDetails,
            $contactInfo,
            $paymentInfo
        );
        // $command = SubmitRegistrationRequest::fromRequest($request);
        $this->dispatch($command);

        return redirect('/register/success');

        return back()->withInput();
    }

    public function success()
    {
        return view('registration.success');
    }

    private function fullNameFrom(Request $request) : FullName
    {
        return new FullName(
            $request->input('firstname'),
            $request->input('middlename'),
            $request->input('surname')
        );
    }

    private function birthdateFrom(Request $request) : DateTimeImmutable
    {
        return DateTimeImmutable::createFromFormat(
            'Y-m-d',
            $request->input('birthdate')
        );
    }

    private function genderFrom(Request $request) : Gender
    {
        return Gender::fromString(
            $request->input('gender')
        );
    }

    private function studyDetailsFrom(Request $request) : StudyDetails
    {
        return new StudyDetails(
            $request->input('student-number'),
            $request->input('study-name'),
            DateTimeImmutable::createFromFormat(
                'Y-m',
                $request->input('study-starting-date')
            ),
            $request->has('study-graduation-date')
                ? DateTimeImmutable::createFromFormat(
                    'Y-m',
                    $request->input('study-graduation-date')
                )
                : null
        );
    }

    private function contactInfoFrom(Request $request) : ContactInfo
    {
        return ContactInfo::describe(
            new Email($request->input('email')),
            new Address(
                $request->input('city'),
                $request->input('zip-code'),
                $request->input('address')
            )
        );
    }

    private function paymentInfoFrom(Request $request) : PaymentInfo
    {
        return new PaymentInfo(true, true);
    }
}
