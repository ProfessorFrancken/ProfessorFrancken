<?php

declare(strict_types=1);

namespace Francken\Features;

class CompaniesFeature extends TestCase
{
    /** @test */
    function companies_are_listed()
    {
        $this->visit('/career/companies')
            ->see('Companies')
            ->see('De Nederlandsche Bank ');


        $this->assertResponseOk();
    }

    /** @test */
    function more_info_about_a_companie_can_be_shown()
    {

        $this->visit('/career/companies');

        $company = $this->crawler()->filter('.company-card a')->first();
        $companyName = $company->filter('img')->first()->attr('alt');

        $this->visit($company->link()->getUri())->see($companyName);
    }

}
