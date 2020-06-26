<?php

declare(strict_types=1);

namespace Francken\Features\Extern;

use Francken\Extern\Http\AdminCompanyProfilesController;
use Francken\Extern\Http\AdminPartnersController;
use Francken\Extern\Partner;
use Francken\Extern\PartnerStatus;
use Francken\Features\LoggedInAsAdmin;
use Francken\Features\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AdminCompanyProfilesFeature extends TestCase
{
    use DatabaseMigrations;
    use LoggedInAsAdmin;

    /** @test */
    public function a_partners_company_profile_can_be_added() : void
    {
        $partner = Partner::create([
            'name' => 'S[ck]rip(t|t?c)ie In[ck]',
            'slug' => str_slug('S[ck]rip(t|t?c)ie In[ck]'),
            'homepage_url' => 'https://scriptcie.nl',
            'sector_id' => 1,
            'status' => PartnerStatus::ACTIVE_PARTNER,
        ]);

        $this->visit(action(
            [AdminPartnersController::class, 'show'],
            ['partner' => $partner]
        ))
            ->click('Enable company profile')
            ->seePageIs((action(
                [AdminCompanyProfilesController::class, 'create'],
                ['partner' => $partner]
            )))
             ->type('# Hoi', 'source_content')
            ->check('is_enabled')
            ->press('Add company profile')
             ->seePageIs((action(
                [AdminPartnersController::class, 'show'],
                ['partner' => $partner]
            )))
            ->dontSee('Enable company profile')
            ->click('Edit company profile')
            ->see('Hoi')
            ->uncheck('is_enabled')
            ->press('Save company profile');

        $profile = $partner->companyProfile;
        $this->assertFalse($profile->is_enabled);
        $this->assertEquals('# Hoi', $profile->source_content);
        $this->assertEquals('S[ck]rip(t|t?c)ie In[ck]', $profile->display_name);
        $this->assertEquals("<h1>Hoi</h1>\n", $profile->compiled_content);
    }
}
