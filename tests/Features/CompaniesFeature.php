<?php

declare(strict_types=1);

namespace Francken\Features;

use Francken\Extern\CompanyRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CompaniesFeature extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function companies_are_listed() : void
    {
        $this->addDNBToCompanies();

        $this->visit('/career/companies')
            ->see('Companies')
            ->see('De Nederlandsche Bank');


        $this->assertResponseOk();
    }

    /** @test */
    public function more_info_about_a_companie_can_be_shown() : void
    {
        $this->addDNBToCompanies();

        $this->visit('/career/companies');

        $company = $this->crawler()->filter('.company-card a')->first();
        $companyName = $company->filter('img')->first()->attr('alt');

        $this->visit($company->link()->getUri())->see($companyName);
    }

    private function addDNBToCompanies() : void
    {
        $this->app->bind(CompanyRepository::class, function ($app) : CompanyRepository {
            return new CompanyRepository(
                [
                    [
                        'name' => 'De Nederlandsche Bank',
                        'summary' => '',
                        'read-more-at' => '',
                        'logo' => 'http://www.professorfrancken.nl/wordpress/media/images/carriereplaza/dnb.png',
                        'footer-link' => '',
                        'footer-logo' => '',
                        'show-in-footer' => true,
                        'show-profile' => true,
                        'metadata' => [
                        ]
                    ]
                ]
            );
        });
    }
}
