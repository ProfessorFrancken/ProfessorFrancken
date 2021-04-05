<?php

declare(strict_types=1);

namespace Francken\Association\Members\Http\Requests;

use DateTimeImmutable;
use Francken\Association\Members\Gender;
use Francken\Shared\Email;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Webmozart\Assert\Assert;

class AdminMemberRequest extends FormRequest
{
    public const CONSUMPTION_COUNTER_OPTIONS = [
        'Afschrijven' => 'Afschrijven',
        'Contant' => 'Contant',
        'Non-actief' => 'Non-actief',
        'Niet' => 'Niet',
    ];

    public const MEMBER_TYPE_OPTIONS = [
        'Student RUG' => 'Student RUG',
        'Student Hanze' => 'Student Hanze',
        'Student Anders' => 'Student Anders',
        'Promovendus' => 'Promovendus',
        'Professor RUG' => 'Professor RUG',
        'Werknemer RUG' => 'Werknemer RUG',
        'Alumnus TN/N' => 'Alumnus TN/N',
        'Alumnus niet TN/N' => 'Alumnus niet TN/N',
        'Gestopt met studeren' => 'Gestopt met studeren',
        'Donateur' => 'Donateur',
        'Anders' => 'Anders',
        'Student' => 'Student (oud)',
        'Alumni' => 'Alumni (oud)',
    ];

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules() : array
    {
        return [
            'gender' => ['required', 'in:female,male,other'],
            'other_gender' => ['required_if:gener,other'],

            "titel" => ['nullable', 'regex:/[a-zA-Z0-9\s]+/'],
            "initialen" => ['nullable', 'regex:/[a-zA-Z0-9\s]+/'],
            "voornaam" => ['required', 'regex:/[a-zA-Z0-9\s]+/', 'min:1'],
            "tussenvoegsel" => ['nullable', 'regex:/[a-zA-Z0-9\s]+/', 'min:1'],
            "achternaam" => ['required', 'regex:/[a-zA-Z0-9\s]+/', 'min:1'],
            "geboortedatum" => ['required', 'date_format:Y-m-d'],
            "nederlands" => ['nullable', 'boolean'],

            "adres" => ['nullable', 'min:1',  'required_with:plaats,postcode,land'],
            "postcode" => ['nullable', 'min:1',  'required_with:plaats,adres,land'],
            "plaats" => ['nullable', 'min:1', 'required_with:adres,postcode,land'],
            "land" => ['nullable', 'min:1',  'required_with:plaats,adres,postcode'],
            "is_nederland" => ['nullable', 'boolean'],
            "emailadres" => ['required', 'email'],
            "telefoonnummer_mobiel" => ['nullable', 'min:1'],

            "rekeningnummer" => ['nullable', 'iban'],
            "plaats_bank" => ['nullable'],
            "machtiging" => ['nullable', 'boolean'],
            "wanbetaler" => ['nullable', 'boolean'],
            "gratis_lidmaatschap" => ['nullable', 'boolean'],

            "start_lidmaatschap" => ['required', 'date_format:Y-m-d'],
            "einde_lidmaatschap" => ['nullable', 'date_format:Y-m-d'],
            "is_lid" => ['nullable', 'boolean'],
            "studentnummer" => ['nullable'],
            "studierichting" => ['nullable'],
            "jaar_van_inschrijving" => ['nullable', 'integer', 'max:9999'],
            "afstudeerplek" => ['nullable'],
            "afgestudeerd" => ['nullable', 'boolean'],
            "werkgever" => ['nullable'],
            "nnvnummer" => ['nullable'],

            "type_lid" => [Rule::in(array_keys(self::MEMBER_TYPE_OPTIONS))],
            "streeplijst" => [Rule::in(self::CONSUMPTION_COUNTER_OPTIONS)],

            "mailinglist_email" => ['nullable', 'boolean'],
            "mailinglist_post" => ['nullable', 'boolean'],
            "mailinglist_sms" => ['nullable', 'boolean'],
            "mailinglist_constitutiekaart" => ['nullable', 'boolean'],
            "mailinglist_franckenvrij" => ['nullable', 'boolean'],
            "erelid" => ['nullable', 'boolean'],
            "notities" => ['nullable'],
        ];
    }

    public function title() : ?string
    {
        return $this->input('titel', '');
    }

    public function initials() : ?string
    {
        return $this->input('initialen', '');
    }

    public function firstname() : string
    {
        return $this->input('voornaam', '');
    }

    public function insertion() : ?string
    {
        return $this->input('tussenvoegsel', '');
    }

    public function surname() : string
    {
        return $this->input('achternaam', '');
    }

    public function birthdate() : DateTimeImmutable
    {
        $date = DateTimeImmutable::createFromFormat('!Y-m-d', $this->input('geboortedatum'));

        Assert::isInstanceOf($date, DateTimeImmutable::class);

        return $date;
    }

    public function knowsDutch() : bool
    {
        return (bool)$this->input('nederlands', false);
    }

    public function hasDutchNationality() : bool
    {
        return (bool)$this->input('is_nederland', false);
    }

    public function address() : ?string
    {
        return $this->input('adres', '');
    }

    public function postalCode() : ?string
    {
        return $this->input('postcode', '');
    }

    public function city() : ?string
    {
        return $this->input('plaats', '');
    }

    public function country() : ?string
    {
        return $this->input('land', '');
    }

    public function email() : Email
    {
        return new Email($this->input('emailadres', ''));
    }

    public function phoneNumber() : ?string
    {
        return $this->input('telefoonnummer_mobiel', '');
    }

    public function iban() : ?string
    {
        return $this->input('rekeningnummer', '');
    }

    public function bankLocation() : ?string
    {
        return $this->input('plaats_bank', '');
    }

    public function hasAuthorizedDebit() : bool
    {
        return (bool)$this->input('machtiging', false);
    }

    public function isDefaulter() : bool
    {
        return (bool)$this->input('wanbetaler', false);
    }

    public function hasFreeMembership() : bool
    {
        return (bool)$this->input('gratis_lidmaatschap', false);
    }

    public function startMembershipDate() : DateTimeImmutable
    {
        $date = DateTimeImmutable::createFromFormat('!Y-m-d', $this->input('start_lidmaatschap'));

        Assert::isInstanceOf($date, DateTimeImmutable::class);

        return $date;
    }

    public function endMembershipDate() : ?DateTimeImmutable
    {
        return $this->toDateTimeImmutable($this->input('einde_lidmaatschap'));
    }

    public function isMember() : bool
    {
        return (bool)$this->input('is_lid', false);
    }

    public function isMemberOfHonors() : bool
    {
        return (bool)$this->input('erelid', false);
    }

    public function memberType() : string
    {
        return $this->input('type_lid');
    }

    public function studentNumber() : ?string
    {
        return $this->input('studentnummer') ?? '';
    }

    public function study() : ?string
    {
        return $this->input('studierichting');
    }

    public function yearOfRegistration() : int
    {
        return (int)$this->input('jaar_van_inschrijving');
    }

    public function placeOfGraduation() : ?string
    {
        return $this->input('afstudeerplek');
    }

    public function isGraduated() : bool
    {
        return (bool)$this->input('afgestudeerd', false);
    }

    public function empoloyer() : ?string
    {
        return $this->input('werkgever', '');
    }

    public function nnvNumber() : ?string
    {
        return $this->input('nnvnummer', '');
    }

    public function consumptionCounterPaymentMethod() : string
    {
        return $this->input('streeplijst', '');
    }

    public function notes() : ?string
    {
        return $this->input('notities', '');
    }

    public function mailingListEmail() : bool
    {
        return (bool)$this->input('mailinglist_email', false);
    }

    public function mailingListPost() : bool
    {
        return (bool)$this->input('mailinglist_post', false);
    }

    public function mailingListSMS() : bool
    {
        return (bool)$this->input('mailinglist_sms', false);
    }

    public function mailingListConstitutionalCard() : bool
    {
        return (bool)$this->input('mailinglist_constitutiekaart', false);
    }

    public function mailingListFranckenVrij() : bool
    {
        return (bool)$this->input('mailinglist_franckenvrij', false);
    }

    public function gender() : Gender
    {
        if ($this->input('gender') === 'female') {
            return Gender::FEMALE();
        }

        if ($this->input('gender') === 'male') {
            return Gender::MALE();
        }

        return Gender::other($this->input('other_gender'));
    }

    private function toDateTimeImmutable(?string $input) : ?DateTimeImmutable
    {
        if ($input === null) {
            return null;
        }

        $dateTime = DateTimeImmutable::createFromFormat('Y-m-d', $input);

        if ($dateTime === false) {
            return null;
        }

        return $dateTime;
    }
}
