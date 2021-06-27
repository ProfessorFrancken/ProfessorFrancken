<?php

declare(strict_types=1);

namespace Francken\Association\Members\Registration;

use DateTimeImmutable;
use Francken\Association\Boards\BoardMember;
use Francken\Association\LegacyMember;
use Francken\Association\Members\Address;
use Francken\Association\Members\Birthdate;
use Francken\Association\Members\ContactDetails;
use Francken\Association\Members\Fullname;
use Francken\Association\Members\Gender;
use Francken\Association\Members\PaymentDetails;
use Francken\Association\Members\PersonalDetails;
use Francken\Association\Members\Registration\Events\MemberWasRegistered;
use Francken\Association\Members\Registration\Events\RegistrationWasApproved;
use Francken\Association\Members\Registration\Events\RegistrationWasSubmitted;
use Francken\Association\Members\Study;
use Francken\Association\Members\StudyDetails;
use Francken\Shared\Email;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webmozart\Assert\Assert;

final class Registration extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'members_registrations';

    /**
     * @var string[]
     */
    protected $casts = [
        'member_id' => 'int',
        'email_verified_at' => 'datetime:Y-m-d',
        'registration_accepted_at' => 'datetime:Y-m-d',
        'registration_form_signed_at' => 'datetime:Y-m-d',
        'birthdate' => 'datetime:Y-m-d',
        'wants_to_join_a_committee' => 'boolean',
        'has_dutch_diploma' => 'boolean',
        'deduct_additional_costs' => 'boolean',
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

        event(new RegistrationWasSubmitted($registration));

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

        event(new RegistrationWasApproved($this, $byMember));
    }

    public function register(LegacyMember $member) : void
    {
        $this->member_id = $member->id;
        $this->save();

        event(new MemberWasRegistered($this));
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

    public function getPersonalDetailsAttribute() : PersonalDetails
    {
        return $this->personalDetails();
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


    public function getContactDetailsAttribute() : ContactDetails
    {
        return new ContactDetails(
            $this->email,
            new Address(
                $this->city ?? '',
                $this->postal_code ?? '',
                $this->address ?? '',
                $this->country ?? ''
            ),
            $this->phone_number
        );
    }

    public function setContactDetailsAttribute(ContactDetails $contactDetails) : void
    {
        $this->attributes['email'] = $contactDetails->email()->toString();
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
        return array_map(
            function (array $study) : Study {
                $start = DateTimeImmutable::createFromFormat('!Y-m-d', $study['start_date']);
                $end = ($study['graduation_date'] !== null)
                    ? DateTimeImmutable::createFromFormat('!Y-m-d', $study['graduation_date'])
                    : null;

                Assert::isInstanceOf($start, DateTimeImmutable::class);
                if ($end !== null) {
                    Assert::isInstanceOf($end, DateTimeImmutable::class);
                }

                return new Study($study['study'], $start, $end);
            },
            json_decode($this->attributes['studies'], true, 512, JSON_THROW_ON_ERROR)
        );
    }

    public function getMostRecentStudyAttribute() : ?Study
    {
        return collect($this->studies)
            ->sortByDesc(fn (Study $study) : DateTimeImmutable => $study->startDate())
            ->first();
    }

    public function getStudyDetailsAttribute() : StudyDetails
    {
        return new StudyDetails($this->student_number, ...$this->studies);
    }

    public function setStudyDetailsAttribute(StudyDetails $studyDetails) : void
    {
        $this->student_number = $studyDetails->studentNumber();
        $this->attributes['studies'] = json_encode(
            array_map(
                fn (Study $study) : array => [
                    'study' => $study->study(),
                    'start_date' => $study->startDate()->format('Y-m-d'),
                    'graduation_date' => $study->graduationDate() !== null ? $study->graduationDate()->format('Y-m-d') : null,
                ],
                $studyDetails->studies()
            ),
            JSON_THROW_ON_ERROR
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
        return array_map(fn (Study $study) : string => $study->study(), $this->studies);
    }

    public function getStudyStartingDateAttribute() : array
    {
        return array_map(fn (Study $study) : string => $study->startDate()->format('Y-m'), $this->studies);
    }

    public function getStudyGraduationDateAttribute() : array
    {
        return array_map(fn (Study $study) : ?string => optional($study->graduationDate())->format('Y-m'), $this->studies);
    }

    public function scopeApproved(Builder $query) : Builder
    {
        return $query->whereNotNull('registration_accepted_at');
    }
}
