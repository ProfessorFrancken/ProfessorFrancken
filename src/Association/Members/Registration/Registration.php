<?php

declare(strict_types=1);

namespace Francken\Association\Members\Registration;

use DateTimeImmutable;
use Francken\Association\Boards\BoardMember;
use Francken\Association\Members\Birthdate;
use Francken\Association\Members\ContactDetails;
use Francken\Association\Members\Email;
use Francken\Association\Members\Fullname;
use Francken\Association\Members\Gender;
use Francken\Association\Members\PaymentDetails;
use Francken\Association\Members\PersonalDetails;
use Francken\Association\Members\Study;
use Francken\Association\Members\StudyDetails;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Registration extends Model
{
    use SoftDeletes;

    protected $table = 'members_registrations';

    protected $casts = [
        'email_verified_at' => 'datetime:Y-m-d',
        'registration_accepted_at' => 'datetime:Y-m-d',
        'registration_form_signed_at' => 'datetime:Y-m-d',
        'birthdate' => 'datetime:Y-m-d',
    ];

    public static function submit(
        PersonalDetails $personalDetails,
        ContactDetails $contactDetails,
        StudyDetails $studyDetails,
        PaymentDetails $paymentDetails,
        bool $wantsToJoinACommittee,
        string $comments
    ) : self {
        $registration = new self();

        $registration->personal_details = $personalDetails;
        $registration->contact_details = $contactDetails;
        $registration->study_details = $studyDetails;
        $registration->payment_details = $paymentDetails;
        $registration->comments = $comments;
        $registration->wants_to_join_a_committee = $wantsToJoinACommittee;

        $registration->save();

        event(new Events\RegistrationWasSubmitted($registration));

        return $registration;
    }

    public function confirmEmail(DateTimeImmutable $at) : void
    {
        $this->email_verified_at = $at;
        $this->save();
    }

    public function approve(BoardMember $byMember, DateTimeImmutable $at) : void
    {
        if ($this->registration_accepted_at !== null) {
            throw RegistrationException::alreadyApproved();
        }

        $this->registration_accepted_at = $at;
        $this->save();
       
        event(
            new Events\RegistrationWasApproved($this, $byMember)
        );
    }

    public function signRegistrationForm(DateTimeImmutable $at) : void
    {
        $this->registration_form_signed_at = $at;
        $this->save();
    }

    public function personalDetails() : PersonalDetails
    {
        return new PersonalDetails(
            $this->fullname,
            $this->initials,
            Gender::fromString($this->gender),
            Birthdate::fromString($this->birthdate->format('Y-m-d')),
            $this->nationality,
            $this->has_dutch_diploma
        );
    }

    public function getFullnameAttribute() : Fullname
    {
        return Fullname::fromFirstnameAndSurname(
            $this->firstname,
            $this->surname
        );
    }

    public function setPersonalDetailsAttribute(PersonalDetails $personalDetails) : void
    {
        $this->firstname = $personalDetails->fullname()->firstname();
        $this->surname = $personalDetails->fullname()->surname();
        $this->initials = $personalDetails->initials();
        $this->gender = $personalDetails->gender()->toString();
        $this->birthdate = $personalDetails->birthdate()->toDateTime();
        $this->has_dutch_diploma = $personalDetails->hasDutchDiploma();
        $this->nationality = $personalDetails->nationality();
    }

    public function getEmailAttribute() : Email
    {
        return new Email($this->attributes['email']);
    }

    public function setContactDetailsAttribute(ContactDetails $contactDetails) : void
    {
        $this->email = $contactDetails->email()->toString();
        $address = $contactDetails->address();
        if ($address !== null) {
            $this->city = $address->city();
            $this->address = $address->address();
            $this->postal_code = $address->postalCode();
            $this->country = $address->country();
        }
        $this->phone_number = $contactDetails->phoneNumber();
    }

    public function getStudiesAttribute() : array
    {
        $studies = array_map(
            function (array $study) : Study {
                $start = DateTimeImmutable::createFromFormat('!Y-m-d', $study['start_date']);
                $end = ($study['graduation_date'] !== null)
                    ? DateTimeImmutable::createFromFormat('!Y-m-d', $study['graduation_date'])
                    : null;

                return new Study($study['study'], $start, $end);
            },
            json_decode($this->attributes['studies'], true)
        );
        return $studies;
    }

    public function setStudyDetailsAttribute(StudyDetails $studyDetails) : void
    {
        $this->student_number = $studyDetails->studentNumber();
        $this->studies = json_encode(
            array_map(
                function (Study $study) : array {
                    return [
                        'study' => $study->study(),
                        'start_date' => $study->startDate()->format('Y-m-d'),
                        'graduation_date' => $study->graduationDate() ? $study->graduationDate()->format('Y-m-d') : null,
                    ];
                },
                $studyDetails->studies()
            )
        );
    }

    public function getPaymentDetailsAttribute() : PaymentDetails
    {
        return new PaymentDetails(
            $this->iban,
            $this->bic,
            (bool) $this->deduct_additional_costs
        );
    }

    public function setPaymentDetailsAttribute(PaymentDetails $paymentDetails) : void
    {
        $this->iban = $paymentDetails->iban();
        $this->bic = $paymentDetails->bic();
        $this->deduct_additional_costs = $paymentDetails->deductAdditionalCosts();
    }

    /**
     * These attribute helpes were made to make updating the registration request easier
     */
    public function getStudyNameAttribute() : array
    {
        return array_map(function (Study $study) : string {
            return $study->study();
        }, $this->studies);
    }

    public function getStudyStartingDateAttribute() : array
    {
        return array_map(function (Study $study) : string {
            return $study->startDate()->format('Y-m');
        }, $this->studies);
    }
                       
    public function getStudyGraduationDateAttribute() : array
    {
        return array_map(function (Study $study) : ?string {
            return optional($study->graduationDate())->format('Y-m');
        }, $this->studies);
    }
}

namespace Francken\Association\Members\Registration;

use Exception;

final class RegistrationException extends Exception
{
    public static function alreadyApproved() : self
    {
        return new self("Tried approving a registration that's been approved before");
    }


    // /**
    //  * Report the exception.
    //  */
    // public function report() : void
    // {
    //     //
    // }

    // /**
    //  * Render the exception into an HTTP response.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function render($request)
    // {
    //     // return response(...);
    // }
}
