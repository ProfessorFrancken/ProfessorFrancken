<?php


declare(strict_types=1);

namespace Francken\Tests\Extern;

use Francken\Extern\Http\Requests\AdminSearchPartnersRequest;
use Francken\Extern\Partner;
use Francken\Extern\PartnerStatus;
use Francken\Extern\SponsorOptions\CompanyProfile;
use Francken\Extern\SponsorOptions\Footer;
use Francken\Extern\SponsorOptions\Vacancy;
use Francken\Tests\LaravelTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PartnerTest extends LaravelTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function partners_can_be_searched_for() : void
    {
        $this->assertCount(0, Partner::all());

        $borrelcie = factory(Partner::class)->create([
            'name' => 'Borrelcie',
            'sector_id' => 10,
            'status' => PartnerStatus::SECONDARY_PARTNER,
        ]);

        $scriptcie = factory(Partner::class)->create([
            'name' => 'S[ck]rip(t|t?c)ie In[ck]',
            'sector_id' => 6,
            'status' => PartnerStatus::PRIMARY_PARTNER,
        ]);

        $allPartners = Partner::query()
            ->search(new AdminSearchPartnersRequest([]))
            ->get();

        $this->assertCount(2, $allPartners);

        $this->assertEquals(
            [$borrelcie->toArray(), $scriptcie->toArray()],
            $allPartners->toArray()
        );

        $partners = Partner::query()
            ->search(new AdminSearchPartnersRequest([
                'name' => 'borrelcie'
            ]))
            ->get();
        $this->assertCount(1, $partners);
        $this->assertEquals(
            [$borrelcie->toArray()],
            $partners->toArray()
        );

        $partners = Partner::query()
            ->search(new AdminSearchPartnersRequest([
                'sector_id' => '6'
            ]))
            ->get();
        $this->assertCount(1, $partners);
        $this->assertEquals(
            [$scriptcie->toArray()],
            $partners->toArray()
        );

        $partners = Partner::query()
            ->search(new AdminSearchPartnersRequest([
                'name' => 'rip',
                'sector_id' => '6',
                'status' => PartnerStatus::PRIMARY_PARTNER,
            ]))
            ->get();

        $this->assertCount(1, $partners);
        $this->assertEquals(
            [$scriptcie->toArray()],
            $partners->toArray()
        );

        $partners = Partner::query()
            ->search(new AdminSearchPartnersRequest([
                'name' => 'rip',
                'sector_id' => '6',
                'status' => PartnerStatus::PRIMARY_PARTNER,
                'has_company_profile' => true,
            ]))
            ->get();

        $this->assertCount(0, $partners);


        factory(CompanyProfile::class)->create([
            'partner_id' => $scriptcie->id
        ]);
        $partners = Partner::query()
            ->search(new AdminSearchPartnersRequest([
                'name' => 'rip',
                'sector_id' => '6',
                'status' => PartnerStatus::PRIMARY_PARTNER,
                'has_company_profile' => true,
            ]))
            ->get();
        $this->assertCount(1, $partners);

        $partners = Partner::query()
            ->search(new AdminSearchPartnersRequest([
                'name' => 'rip',
                'sector_id' => '6',
                'status' => PartnerStatus::PRIMARY_PARTNER,
                'has_company_profile' => true,
                'has_footer' => true,
            ]))
            ->get();

        $this->assertCount(0, $partners);

        factory(Footer::class)->create([
            'partner_id' => $scriptcie->id
        ]);
        $partners = Partner::query()
            ->search(new AdminSearchPartnersRequest([
                'name' => 'rip',
                'sector_id' => '6',
                'status' => PartnerStatus::PRIMARY_PARTNER,
                'has_company_profile' => true,
                'has_footer' => true,
            ]))
            ->get();

        $this->assertCount(1, $partners);

        $partners = Partner::query()
            ->search(new AdminSearchPartnersRequest([
                'name' => 'rip',
                'sector_id' => '6',
                'status' => PartnerStatus::PRIMARY_PARTNER,
                'has_company_profile' => true,
                'has_footer' => true,
                'has_vacancies' => true,
            ]))
            ->get();

        $this->assertCount(0, $partners);


        factory(Vacancy::class)->create([
            'partner_id' => $scriptcie->id
        ]);
        $partners = Partner::query()
            ->search(new AdminSearchPartnersRequest([
                'name' => 'rip',
                'sector_id' => '6',
                'status' => PartnerStatus::PRIMARY_PARTNER,
                'has_company_profile' => true,
                'has_footer' => true,
                'has_vacancies' => true,
            ]))
            ->get();

        $this->assertCount(1, $partners);
    }
}
