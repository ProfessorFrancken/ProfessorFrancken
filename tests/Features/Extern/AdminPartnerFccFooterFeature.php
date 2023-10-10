<?php

declare(strict_types=1);

namespace Francken\Features\Extern;

use Francken\Extern\Http\AdminFccFootersController;
use Francken\Extern\Http\AdminPartnersController;
use Francken\Extern\Partner;
use Francken\Extern\PartnerStatus;
use Francken\Features\LoggedInAsAdmin;
use Francken\Features\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class AdminPartnerFccFooterFeature extends TestCase
{
    use LoggedInAsAdmin;

    /** @test */
    public function a_partners_logo_can_be_listed_in_the_fcc_footer() : void
    {
        $partner = Partner::create([
            'name' => 'S[ck]rip(t|t?c)ie In[ck]',
            'slug' => Str::slug('S[ck]rip(t|t?c)ie In[ck]'),
            'homepage_url' => 'https://scriptcie.nl',
            'sector_id' => 1,
            'status' => PartnerStatus::ACTIVE_PARTNER,
        ]);

        $this->visit(action(
            [AdminPartnersController::class, 'show'],
            ['partner' => $partner]
        ))
            ->click('Enable fcc footer')
            ->seePageIs((action(
                [AdminFccFootersController::class, 'create'],
                ['partner' => $partner]
            )))
            ->attach(UploadedFile::fake()->image('scriptcie.png'), 'logo')
            ->check('is_enabled')
            ->press('Add footer')
             ->seePageIs((action(
                 [AdminPartnersController::class, 'show'],
                 ['partner' => $partner]
             )))
            ->dontSee('Enable fcc footer')
            ->click('Edit fcc footer')
            ->uncheck('is_enabled')
            ->press('Save footer');

        $footer = $partner->fccFooter;
        $this->assertFalse($footer->is_enabled);
    }
}
