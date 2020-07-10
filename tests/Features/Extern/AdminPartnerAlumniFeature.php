<?php

declare(strict_types=1);

namespace Francken\Features\Extern;

use Francken\Association\LegacyMember;
use Francken\Extern\Http\AdminPartnerAlumniController;
use Francken\Extern\Http\AdminPartnersController;
use Francken\Extern\Partner;
use Francken\Features\LoggedInAsAdmin;
use Francken\Features\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AdminPartnerAlumniFeature extends TestCase
{
    use DatabaseMigrations;
    use LoggedInAsAdmin;

    /** @test */
    public function a_partners_logo_can_be_listed_in_the_alumnus() : void
    {
        $partner = factory(Partner::class)->create();
        $member = factory(LegacyMember::class)->create();

        $this->visit(action(
            [AdminPartnersController::class, 'show'],
            ['partner' => $partner]
        ))
            ->click('Add alumnus')
            ->seePageIs((action(
                [AdminPartnerAlumniController::class, 'create'],
                ['partner' => $partner]
            )))
             ->type($member->id, 'member_id')
             ->type('Senior engineer', 'position')
             ->type('2020-01-01', 'started_position_at')
             ->type('2020-02-01', 'stopped_position_at')
             ->type('Contact for sponsorsing', 'notes')
            ->press('Add alumnus')
             ->seePageIs((action(
                [AdminPartnersController::class, 'show'],
                ['partner' => $partner]
            )))
            ->see($member->fullname)
            ->see('Senior engineer')
            ->click('Edit alumnus')
            ->see('Edit ' . $member->fullname)
            ->type('', 'stopped_position_at')
            ->press('Save alumnus');

        $this->assertCount(1, $partner->alumni);
    }
}
