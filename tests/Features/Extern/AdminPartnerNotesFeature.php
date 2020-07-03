<?php

declare(strict_types=1);

namespace Francken\Features\Extern;

use Francken\Extern\Http\AdminPartnersController;
use Francken\Extern\Partner;
use Francken\Extern\PartnerStatus;
use Francken\Features\LoggedInAsAdmin;
use Francken\Features\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AdminPartnerNotesFeature extends TestCase
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
            ->type('Hoi', 'note')
            ->press('Save note')
            ->seePageIs((action(
                [AdminPartnersController::class, 'show'],
                ['partner' => $partner]
            )))
            ->see('Hoi');

        $this->assertCount(1, $partner->notes);
    }
}
