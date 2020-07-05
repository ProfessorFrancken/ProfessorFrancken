<?php

declare(strict_types=1);

namespace Francken\Features\Extern;

use Francken\Extern\Http\AdminPartnerAlumniController;
use Francken\Extern\Http\AdminPartnersController;
use Francken\Extern\Partner;
use Francken\Extern\PartnerStatus;
use Francken\Features\LoggedInAsAdmin;
use Francken\Features\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Str;

class AdminPartnerAlumniFeature extends TestCase
{
    use DatabaseMigrations;
    use LoggedInAsAdmin;

    /** @test */
    public function a_partners_logo_can_be_listed_in_the_alumnus() : void
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
            ->click('Add alumnus')
            ->seePageIs((action(
                [AdminPartnerAlumniController::class, 'create'],
                ['partner' => $partner]
            )))
             ->type('1403', 'member_id')
             ->type('Senior engineer', 'position')
             ->type('2020-01-01', 'started_position_at')
             ->type('2020-02-01', 'stopped_position_at')
             ->type('Contact for sponsorsing', 'notes')
            ->press('Add alumnus')
             ->seePageIs((action(
                [AdminPartnersController::class, 'show'],
                ['partner' => $partner]
            )))
            ->see('Mark Redeman')
            ->see('Senior engineer')
            ->click('Edit alumnus')
            ->see('Edit Mark Redeman')
            ->type('', 'stopped_position_at')
            ->press('Save alumnus');

        $this->assertCount(1, $partner->alumni);
    }
}
