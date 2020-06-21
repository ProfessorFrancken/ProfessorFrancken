<?php

declare(strict_types=1);

namespace Francken\Association\Members\Registration\EventHandlers;

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
        $registration->member_id = $member->id;
        $registration->save();

        // TODO
        $this->activateMemberAccount($registration, $member);
        $this->subscribeToMailchimp($registration, $member);
    }

    private function registerMemberToLegacyDatabase(Registration $registration) : LegacyMember
    {
        [$study_track, $year_of_registration] = $this->study($registration);
        $hasAddress =$this->hasAddress($registration);
                                                            
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

    private function study(Registration $registration) : array
    {
        $study = $registration->most_recent_study;

        if ($study === null) {
            return ["Anders", date("Y")];
        }

        return [$study->study(), $study->startDate()->format('Y')];
    }

    private function hasAddress(Registration $registration) : bool
    {
        return collect([
            $registration->address,
            $registration->postal_code,
            $registration->city,
            $registration->country
        ])->every(function (?string $field) {
            return $field !== null;
        });
    }

    private function subscribeToMailchimp(Registration $registration, LegacyMember $member) : void
    {
    }

    private function activateMemberAccount(Registration $registration, LegacyMember $member) : void
    {
    }
}
