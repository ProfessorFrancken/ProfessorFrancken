<?php

declare(strict_types=1);

namespace Francken\Infrastructure\Http\Controllers;

use DateTimeImmutable;
use Francken\Application\Members\Registration\SubmitRegistrationRequest;
use Francken\Domain\Members\Address;
use Francken\Domain\Members\ContactInfo;
use Francken\Domain\Members\Email;
use Francken\Domain\Members\FullName;
use Francken\Domain\Members\Gender;
use Francken\Domain\Members\PaymentInfo;
use Francken\Domain\Members\Registration\RegistrationRequestId;
use Francken\Domain\Members\Registration\RegistrationRequestRepository as Repository;
use Francken\Domain\Members\Study;
use Francken\Domain\Members\StudyDetails;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function request()
    {
        return view('registration.request')
            ->with('amountOfStudies', session()->get('amountOfStudies', 1) - 1);
    }

    public function submitRequest(Request $request, Repository $repo)
    {
        try {
            // Gather all the given inputs and put them into value objects
            // that are needed by the SubmitRegistrationRequest command
            $name = $this->fullNameFrom($request);
            $birthdate = $this->birthdateFrom($request);
            $gender = $this->genderFrom($request);
            $studyDetails = $this->studyDetailsFrom($request);
            $contactInfo = $this->contactInfoFrom($request);
            $paymentInfo = $this->paymentInfoFrom($request);

            /** @var RegistrationRequestId */
            $id = RegistrationRequestId::generate();

            $command = new SubmitRegistrationRequest(
                $id,
                $name,
                $birthdate,
                $gender,
                $studyDetails,
                $contactInfo,
                $paymentInfo
            );


            $this->dispatch($command);

            return redirect('/register/success');
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('amountOfStudies', count($request->input('study-name')));
        }
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
        // A student can have multiple studies, since we currently
        $studies = array_map(function ($name, $start, $end) {
            $end = DateTimeImmutable::createFromFormat('Y-m', $end);

            return new Study(
                $name,
                DateTimeImmutable::createFromFormat(
                    'Y-m',
                    $start
                ),
                $end ? $end : null
            );
        },
            request()->input('study-name'),
            request()->input('study-starting-date'),
            request()->input('study-graduation-date')
        );

        return new StudyDetails(
            $request->input('student-number'),
            ...$studies
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
        return new PaymentInfo(true, true, $request->input('iban'));
    }
}
