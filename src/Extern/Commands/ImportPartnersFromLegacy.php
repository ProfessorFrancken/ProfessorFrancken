<?php

declare(strict_types=1);

namespace Francken\Extern\Commands;

use Francken\Association\Members\Gender;
use Francken\Extern\CompanyRepository;
use Francken\Extern\Contact;
use Francken\Extern\ContactDetails;
use Francken\Extern\JobOpeningRepository;
use Francken\Extern\Note;
use Francken\Extern\Partner;
use Francken\Extern\PartnerStatus;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

final class ImportPartnersFromLegacy extends Command
{
    private const GUEST_ID = 1098;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'extern:import-partners';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate the old "bedrijven" table to partners';

    /**
     * Execute the console command.
     */
    public function handle(CompanyRepository $companiesRepo, JobOpeningRepository $jobsRepo) : void
    {
        $bedrijven = \DB::connection('francken-legacy')->table('bedrijven')->get();

        $companies = $bedrijven->map(function ($bedrijf) : array {
            $partner = Partner::create([
                'name' => $bedrijf->naam,
                'sector_id' => $this->determineSector($bedrijf),
                'logo_media_id' => null,
                'homepage_url' => $bedrijf->website,
                'slug' => str_slug($bedrijf->naam),
                'status' => $this->determineStatus($bedrijf),
            ]);

            $notes = $this->partnerNotes($bedrijf);
            $contactDetails = $this->contactDetails($bedrijf);
            $contact = $this->contact($bedrijf);

            $partner->save();
            $notes->each(function (Note $note) use ($partner) : void {
                $partner->notes()->save($note);
            });
            $partner->contactDetails()->save($contactDetails);

            $partner->contacts()->save($contact);
            $contact->contactDetails()->save($contactDetails);

            $partner->created_at = $bedrijf->created_at;
            $partner->updated_at = $bedrijf->updated_at;
            $partner->deleted_at = $bedrijf->deleted_at;
            $partner->save(['timestamps' => false]);
            return [$partner];
        });

        $this->info("Imported {$companies->count()} companies");
    }

    private function determineSector($bedrijf) : int
    {
        return 1;
    }

    private function determineStatus($bedrijf) : string
    {
        $categoryToStatus = [
            "hoofdsponsor" => PartnerStatus::PRIMARY_PARTNER,
            "Hoofdsponsor" => PartnerStatus::PRIMARY_PARTNER,
            "co-sponsor" => PartnerStatus::SECONDARY_PARTNER,

            "potentieel" => PartnerStatus::POTENTIAL_PARTNER,

            "sponsor" => PartnerStatus::ACTIVE_PARTNER,
            "symposiumsponsor" => PartnerStatus::ACTIVE_PARTNER,
            "mailingsponsor" => PartnerStatus::ACTIVE_PARTNER,
            "Sponsor" => PartnerStatus::ACTIVE_PARTNER,
            "Expedition Strategy 2018" => PartnerStatus::POTENTIAL_PARTNER,

            "oudsponsor" => PartnerStatus::PAST_PARTNER,

            "" => PartnerStatus::OTHER_PARTNER,
            "stamkroeg" => PartnerStatus::OTHER_PARTNER,
            "FV heen sturen" => PartnerStatus::OTHER_PARTNER,
        ];
       
        return $categoryToStatus[$bedrijf->categorie] ?? PartnerStatus::OTHER_PARTNER;
    }

    private function findCompanyAndJobs($bedrijf, Collection $companies, Collection $jobs)
    {
        $company = $companies->filter(function (array $company) use ($bedrijf) {
            return strtolower($company['name'] ?? '') === strtolower($bedrijf->naam);
        })->first();

        $vacancies = $jobs->filter(function (array $company) use ($bedrijf) {
            return strtolower($company['name'] ?? '') === strtolower($bedrijf->naam);
        });

        return [$company, $vacancies];
    }

    private function partnerNotes($bedrijf) : Collection
    {
        $notes = collect();
        if ($bedrijf->sponsoring !=='') {
            $notes->push(
                new Note([
                    'note' => $bedrijf->sponsoring,
                    'member_id' => self::GUEST_ID,
                ])
            );
        }
        if ($bedrijf->notities !== '') {
            $notes->push(
                new Note([
                    'note' => $bedrijf->notities,
                    'member_id' => self::GUEST_ID,
                ])
            );
        }
        return $notes;
    }
    

    private function contactDetails($bedrijf) : ContactDetails
    {
        $country = $bedrijf->land === '' ? 'Netherlands' : $bedrijf->land;

        return new ContactDetails([
            'email' => $bedrijf->emailadres,
            'phone_number' => $bedrijf->telefoonnummer_werk,
            'department' => $bedrijf->afdeling,
            'city' => $bedrijf->plaats,
            'address' => $bedrijf->adres,
            'postal_code' => $bedrijf->postcode,
            'country' => $country,
        ]);
    }

    private function contact($bedrijf) : Contact
    {
        $geslachtToGender = [
            'V' => Gender::FEMALE,
            'M' => Gender::MALE,
            '' => '',
        ];
        $contact = new Contact([
            'firstname' => $bedrijf->voornaam,
            'surname' => implode(' ', [$bedrijf->tussenvoegsel, $bedrijf->achternaam]),
            'title' => $bedrijf->titel,
            'position' => $bedrijf->functie,
            'notes' => '',
            'gender' => $geslachtToGender[$bedrijf->geslacht] ?? '',
        ]);

        return $contact;
    }
}
