<?php

declare(strict_types=1);

namespace Francken\Association\Members\Registration\EventHandlers;

use DateTimeImmutable;
use Francken\Association\LegacyMember;
use Francken\Association\Members\Gender;
use Francken\Association\Members\Registration\Events\RegistrationWasApproved;
use Francken\Association\Members\Registration\Registration;
use Francken\Association\Members\Study;
use Illuminate\Contracts\Queue\ShouldQueue;

final class RegisterMember implements ShouldQueue
{
    public function handle(RegistrationWasApproved $event) : void
    {
        $registration = $event->registration;

        $member = $this->registerMemberToLegacyDatabase($registration);

        $this->subscribeToMailchimp($registration, $member);
        $this->activateMemberAccount($registration, $member);
        // TODO:
        // Add member to legacy database
        // Add member to mailchimp
        // Activate account
    }

    private function registerMemberToLegacyDatabase(Registration $registration) : LegacyMember
    {
        // Francken\Association\LegacyMember {#3844
        //   id: 1403,
        //   geslacht: "M",
        //   titel: "Ir.",
        //   initialen: "M.S.",
        //   voornaam: "Mark",
        //   tussenvoegsel: "",
        //   achternaam: "Redeman",
        //   geboortedatum: "1993-04-26",
        //   foto: "",
        //   nederlands: 1,
        //   adres: "Grote rozenstraat 26-3",
        //   postcode: "9712 TH",
        //   plaats: "Groningen",
        //   land: "Nederland",
        //   is_nederland: 1,
        //   emailadres: "markredeman@gmail.com",
        //   telefoonnummer_thuis: "",
        //   telefoonnummer_werk: "",
        //   telefoonnummer_mobiel: "0611759379",
        //   rekeningnummer: "NL26INGB0008673001",
        //   plaats_bank: "",
        //   machtiging: 1,
        //   wanbetaler: 0,
        //   gratis_lidmaatschap: 0,
        //   start_lidmaatschap: "2013-12-03",
        //   einde_lidmaatschap: null,
        //   is_lid: 1,
        //   type_lid: "Student RUG",
        //   studentnummer: "2218356",
        //   studierichting: "(Technische) Wiskunde",
        //   jaar_van_inschrijving: "2013",
        //   afstudeerplek: "",
        //   afgestudeerd: 0,
        //   werkgever: "",
        //   nnvnummer: "",
        //   streeplijst: "Afschrijven",
        //   mailinglist_email: 1,
        //   mailinglist_post: 1,
        //   mailinglist_sms: 0,
        //   mailinglist_constitutiekaart: 0,
        //   mailinglist_franckenvrij: 1,
        //   erelid: 0,
        //   notities: "Hoi.",
        //   created_at: "2013-12-03 15:13:16",
        //   updated_at: "2020-02-25 17:11:19",
        //   deleted_at: null,
        // }

        $study_track = "Anders";
        $year_of_registration = date("Y");
        $study = collect($registration->studies)
                 ->sortByDesc(function (Study $study) : DateTimeImmutable {
                     return $study->startDate();
                 })
                 ->first();

        if ($study !== null) {
            $year_of_registration = $study->startDate()->format('Y');
            $study_track = $study->study();
        }

        $hasAddress = collect([
            $registration->address,
            $registration->postal_code,
            $registration->city,
            $registration->country
        ])->every(function (?string $field) {
            return $field !== null;
        });

        $legacyMember = LegacyMember::create([
            "geslacht" => $this->gender($registration),
            "initialen" => $registration->initials,
            "voornaam" => $registration->fullname->firstname(),
            "achternaam" => $registration->fullname->surname(),
            "geboortedatum" => $registration->birthdate->format("Y-m-d"),
            "nederlands" => $registration->has_dutch_diploma || in_array($registration->nationality, ['Nederland', 'Nederlands', 'Netherlands', 'Dutch'], true),
            "adres" => $registration->address,
            "postcode" => $registration->postal_code,
            "plaats" => $registration->city,
            "land" => $registration->country,
            "is_nederland" => in_array($registration->country, ['Nederland', 'Netherlands'], true),
            "emailadres" => $registration->email,
            "telefoonnummer_mobiel" => $registration->phone_number,
            "rekeningnummer" => $registration->iban,
            "plaats_bank" => null, // TODO
            "machtiging" => $registration->deduct_additional_costs,
            // wanbetaler
            // gratis_lidmaatschap
            "start_lidmaatschap" => $registration->registration_accepted_at,
            // einde_lidmaatschap
            "is_lid" => true,
            "type_lid" => "Student RUG",
            "studentnummer" => $registration->student_number,
            "studierichting" => $study_track,
            "jaar_van_inschrijving" => $year_of_registration,
            // afstudeerplek
            // afgestudeerd
            // werkgever
            // nnvnummer
            "streeplijst" => $registration->deduct_additional_costs ? "Afschrijven" : "Non-actief",
            "mailinglist_email" => true,
            "mailinglist_post" => $hasAddress,
            "mailinglist_sms" => false,
            "mailinglist_constitutiekaart" => true,
            "mailinglist_franckenvrij" => true,
            // erelid
            // notities
        ]);
        
        return $legacyMember;
    }

    private function gender(Registration $registration) : string
    {
        if ($registration->gender === Gender::FEMALE) {
            return 'V';
        }
        if ($registration->gender === Gender::MALE) {
            return 'M';
        }
        return $registration->gender;
    }

    private function subscribeToMailchimp(Registration $registration, LegacyMember $member) : void
    {
    }

    private function activateMemberAccount(Registration $registration, LegacyMember $member): void
    {
    }
}
