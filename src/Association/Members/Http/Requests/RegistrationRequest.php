<?php

declare(strict_types=1);

namespace Francken\Association\Members\Http\Requests;

use DateTimeImmutable;
use Francken\Association\Members\Address;
use Francken\Association\Members\Birthdate;
use Francken\Association\Members\ContactDetails;
use Francken\Association\Members\Email;
use Francken\Association\Members\Fullname;
use Francken\Association\Members\Gender;
use Francken\Association\Members\PaymentDetails;
use Francken\Association\Members\PersonalDetails;
use Francken\Association\Members\Study;
use Francken\Association\Members\StudyDetails;
use Illuminate\Foundation\Http\FormRequest;
use Webmozart\Assert\Assert;

class RegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize() : bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules() : array
    {
        return [
            'firstname' => ['required', 'regex:/[a-zA-Z0-9\s]+/', 'min:1'],
            'surname' => ['required', 'regex:/[a-zA-Z0-9\s]+/', 'min:1'],
            // Initials aren't necessary as these could be filled in later
            'initials' => [],
            'birthdate' => ['required', 'date_format:Y-m-d'],

            // We assume members are Dutch
            'no_dutch_high_school_diploma' => ['boolean'],
            'nationality' => ['required_with:no_dutch_high_school_diploma'],

            'gender' => ['required', 'in:female,male,other'],
            'other_gender' => ['required_if:gener,other'],

            'email' => ['required', 'email'],
            'city' => ['nullable', 'min:1', 'required_with:address,postal_code,country'],
            'address' => ['nullable', 'min:1',  'required_with:city,postal_code,country'],
            'postal_code' => ['nullable', 'min:1',  'required_with:city,address,country'],
            'country' => ['nullable', 'min:1',  'required_with:city,address,postal_code'],
            'phone_number' => ['nullable', 'min:1'],

            // TODO add regex for studnet number
            // 'student_number' => ['required', 'regex:(s|p)\d+'],
            'study_name.*' => ['required', 'min:1'],
            'study_starting_date.*' => ['required', 'date_format:Y-m'],
            'study_graduation_date.*' => ['nullable', 'date_format:Y-m', 'after:study_starting_date.*'],

            'iban' => ['nullable', 'iban'],
            'deduct_additional_costs' => ['nullable', 'boolean'],

            'notes' => ['nullable'],
            'wants_to_join_committee' => ['nullable', 'boolean'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages() : array
    {
        return [
            'study_name.*.required' => 'We need to know your study',
            'study_starting_date.*.required' => 'We need to know the starting date of your study',
        ];
    }

    public function personalDetails() : PersonalDetails
    {
        return new PersonalDetails(
            $this->fullname(),
            $this->input('initials') ?? '',
            $this->gender(),
            $this->birthdate(),
            $this->nationality(),
            $this->hasDutchDiploma()
        );
    }

    public function contactDetails() : ContactDetails
    {
        $address = null;
        if (collect([
            'city', 'postal_code', 'address', 'country'
        ])->every(function (string $field) : bool {
            return $this->input($field, null) !== null;
        })) {
            $address = new Address(
                $this->input('city', null),
                $this->input('postal_code'),
                $this->input('address'),
                $this->input('address', 'Netherlands')
            );
        }

        return new ContactDetails(
            new Email($this->input('email')),
            $address,
            $this->input('phone_number', null)
        );
    }
    public function studyDetails() : StudyDetails
    {
        // A student can have multiple studies, since we currently
        $studies = array_map(
            function (string $name, string $start, ?string $end) : Study {
                $start = DateTimeImmutable::createFromFormat('!Y-m', $start);
                Assert::isInstanceOf($start, DateTimeImmutable::class);

                if ($end !== null) {
                    $end = DateTimeImmutable::createFromFormat('!Y-m', $end);
                    Assert::isInstanceOf($end, DateTimeImmutable::class);
                }

                return new Study($name, $start, $end);
            },
            $this->input('study_name'),
            $this->input('study_starting_date'),
            $this->input('study_graduation_date')
        );

        return new StudyDetails(
            $this->input('student_number'),
            ...$studies
        );
    }

    public function paymentDetails() : PaymentDetails
    {
        return new PaymentDetails(
            $this->input('iban'),
            null,
            (bool)$this->input('deduct_additional_costs', false)
        );
    }

    public function notes() : string
    {
        return $this->input('comments') ?? '';
    }

    public function wantsToJoinACommittee() : bool
    {
        return (bool)$this->input('wants_to_join_a_committee', false);
    }

    private function fullname() : Fullname
    {
        return Fullname::fromFirstnameAndSurname(
            $this->input('firstname'),
            $this->input('surname')
        );
    }

    private function nationality() : string
    {
        return $this->input('nationality') ?? 'Netherlands';
    }

    private function hasDutchDiploma() : bool
    {
        return (bool)$this->input('no_dutch_high_school_diploma', false) === false;
    }

    private function gender() : Gender
    {
        if ($this->input('gender') === 'female') {
            return Gender::FEMALE();
        }

        if ($this->input('gender') === 'male') {
            return Gender::MALE();
        }

        return Gender::other($this->input('other_gender'));
    }

    private function birthdate() : Birthdate
    {
        return Birthdate::fromString($this->input('birthdate'));
    }
}
