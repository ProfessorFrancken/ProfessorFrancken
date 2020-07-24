<?php

declare(strict_types=1);

namespace Francken\Features;

use Francken\Extern\Http\CompaniesController;
use Francken\Extern\Partner;
use Francken\Extern\SponsorOptions\CompanyProfile;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Plank\Mediable\Media;

class CompaniesFeature extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function companies_are_listed() : void
    {
        factory(CompanyProfile::class)->create([
            'partner_id' => factory(Partner::class)->create([
                'name' => 'S[ck]rip(t|t?c)ie In[ck]'
            ])->id,
            'is_enabled' => true,
        ]);

        $this->visit(action([CompaniesController::class, 'index']))
            ->see('Companies')
            ->see('S[ck]rip(t|t?c)ie In[ck]');

        $this->assertResponseOk();
    }

    /** @test */
    public function more_info_about_a_companie_can_be_shown() : void
    {
        factory(CompanyProfile::class)->create([
            'partner_id' => factory(Partner::class)->create([
                'name' => 'S[ck]rip(t|t?c)ie In[ck]',
                'logo_media_id' => factory(Media::class)->create(),
            ])->id,
            'is_enabled' => true,
        ]);

        $this->visit(action([CompaniesController::class, 'index']));

        $company = $this->crawler()->filter('.company-card a')->first();
        $companyName = $company->filter('img')->first()->attr('alt');

        $this->visit($company->link()->getUri())->see($companyName);
    }

    /** @test */
    public function it_doest_show_partners_without_a_company_profile() : void
    {
        factory(CompanyProfile::class)->create([
            'partner_id' => factory(Partner::class)->create([
                'name' => 'S[ck]rip(t|t?c)ie In[ck]'
            ])->id,
            'is_enabled' => false,
        ]);

        $this->visit(action([CompaniesController::class, 'index']))
            ->see('Companies')
            ->dontSee('S[ck]rip(t|t?c)ie In[ck]');

        $this->assertResponseOk();
    }

    /** @test */
    public function it_doest_show_a_partner_without_a_company_profile() : void
    {
        $scriptcie = factory(Partner::class)->create([
            'name' => 'S[ck]rip(t|t?c)ie In[ck]'
        ]);
        factory(CompanyProfile::class)->create([
            'partner_id' => $scriptcie->id,
            'is_enabled' => false,
        ]);



        $this->get(action([CompaniesController::class, 'show'], ['partner' => $scriptcie]));
        $this->assertResponseStatus(404);
    }
}
