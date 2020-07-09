<?php

declare(strict_types=1);

namespace Francken\Association\Members\Registration;

use DateTimeImmutable;
use Francken\Association\Boards\BoardMember;
use Francken\Association\LegacyMember;
use Francken\Association\Members\Birthdate;
use Francken\Association\Members\ContactDetails;
use Francken\Association\Members\Email;
use Francken\Association\Members\Fullname;
use Francken\Association\Members\Gender;
use Francken\Association\Members\PaymentDetails;
use Francken\Association\Members\PersonalDetails;
use Francken\Association\Members\Registration\Events\MemberWasRegistered;
use Francken\Association\Members\Registration\Events\RegistrationWasApproved;
use Francken\Association\Members\Registration\Events\RegistrationWasSubmitted;
use Francken\Association\Members\Study;
use Francken\Association\Members\StudyDetails;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * Francken\Association\Members\Registration\Registration
 *
 * @property int $id
 * @property string $firstname
 * @property string $surname
 * @property string $initials
 * @property string $gender
 * @property mixed $birthdate
 * @property bool $has_dutch_diploma
 * @property string $nationality
 * @property Email $email
 * @property string|null $city
 * @property string|null $address
 * @property string|null $postal_code
 * @property string|null $country
 * @property string|null $phone_number
 * @property string $student_number
 * @property array $studies
 * @property string|null $iban
 * @property string|null $bic
 * @property bool $deduct_additional_costs
 * @property string $comments
 * @property bool $wants_to_join_a_committee
 * @property mixed|null $email_verified_at
 * @property mixed|null $registration_accepted_at
 * @property mixed|null $registration_form_signed_at
 * @property int|null $member_id
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Fullname $fullname
 * @property-read Study|null $most_recent_study
 * @property \Francken\Association\Members\PaymentDetails $payment_details
 * @property-read array $study_graduation_date
 * @property-read array $study_name
 * @property-read array $study_starting_date
 * @property-write mixed $contact_details
 * @property-write mixed $personal_details
 * @property-write mixed $study_details
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Members\Registration\Registration newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Members\Registration\Registration newQuery()
 * @method static \Illuminate\Database\Query\Builder|\Francken\Association\Members\Registration\Registration onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Members\Registration\Registration query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Members\Registration\Registration whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Members\Registration\Registration whereBic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Members\Registration\Registration whereBirthdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Members\Registration\Registration whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Members\Registration\Registration whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Members\Registration\Registration whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Members\Registration\Registration whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Members\Registration\Registration whereDeductAdditionalCosts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Members\Registration\Registration whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Members\Registration\Registration whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Members\Registration\Registration whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Members\Registration\Registration whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Members\Registration\Registration whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Members\Registration\Registration whereHasDutchDiploma($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Members\Registration\Registration whereIban($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Members\Registration\Registration whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Members\Registration\Registration whereInitials($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Members\Registration\Registration whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Members\Registration\Registration whereNationality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Members\Registration\Registration wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Members\Registration\Registration wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Members\Registration\Registration whereRegistrationAcceptedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Members\Registration\Registration whereRegistrationFormSignedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Members\Registration\Registration whereStudentNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Members\Registration\Registration whereStudies($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Members\Registration\Registration whereSurname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Members\Registration\Registration whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Members\Registration\Registration whereWantsToJoinACommittee($value)
 * @method static \Illuminate\Database\Query\Builder|\Francken\Association\Members\Registration\Registration withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\Francken\Association\Members\Registration\Registration withoutTrashed()
 * @mixin \Eloquent
 */
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

                return new Study($study['study'], $start, $end);
            },
            json_decode($this->attributes['studies'], true, 512, JSON_THROW_ON_ERROR)
        );
    }

    public function getMostRecentStudyAttribute() : ?Study
    {
        return collect($this->studies)
            ->sortByDesc(function (Study $study) : DateTimeImmutable {
                return $study->startDate();
            })
            ->first();
    }

    public function setStudyDetailsAttribute(StudyDetails $studyDetails) : void
    {
        $this->student_number = $studyDetails->studentNumber();
        $this->attributes['studies'] = json_encode(
            array_map(
                function (Study $study) : array {
                    return [
                        'study' => $study->study(),
                        'start_date' => $study->startDate()->format('Y-m-d'),
                        'graduation_date' => $study->graduationDate() !== null ? $study->graduationDate()->format('Y-m-d') : null,
                    ];
                },
                $studyDetails->studies()
            ), JSON_THROW_ON_ERROR
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
