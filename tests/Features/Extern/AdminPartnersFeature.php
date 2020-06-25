<?php

declare(strict_types=1);

namespace Francken\Features\Extern;

use Francken\Extern\Http\AdminPartnersController;
use Francken\Extern\Partner;
use Francken\Extern\PartnerStatus;
use Francken\Extern\Sector;
use Francken\Features\LoggedInAsAdmin;
use Francken\Features\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;

class AdminPartnersFeature extends TestCase
{
    use DatabaseMigrations;
    use LoggedInAsAdmin;

    /** @test */
    public function a_list_of_partners_is_shown() : void
    {
        $this->visit(action([AdminPartnersController::class, 'index']));

        $this->assertResponseOk();
    }

    /** @test */
    public function a_partner_can_be_added() : void
    {
        $this->withoutExceptionHandling();
        try {
            $sector_id = Sector::where('name', 'IT and programming')
                ->firstOrFail()
                ->id;

            $this->visit(action([AdminPartnersController::class, 'index']))
            ->click('Add a partner')
            ->see('Add a new partner')
            ->type('S[ck]rip(t|t?c)ie In[ck]', 'name')
            ->select($sector_id, 'sector_id')
            ->type('https://scriptcie.nl', 'homepage_url')
            ->type('https://scriptcie.nl?referal=francken', 'referral_url')
            ->select(PartnerStatus::ACTIVE_PARTNER, 'status')
            ->attach(UploadedFile::fake()->image('scriptcie.png'), 'logo')
            ->press('Add');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->errors();
            dd($errors);
        }

        $partner = Partner::where('name', 'S[ck]rip(t|t?c)ie In[ck]')->firstOrFail();
        $previous_logo_id = $partner->logo_media_id;

        $this->assertEquals('S[ck]rip(t|t?c)ie In[ck]', $partner->name);
        $this->assertEquals('https://scriptcie.nl', $partner->homepage_url);
        $this->assertEquals('https://scriptcie.nl?referal=francken', $partner->referral_url);
        $this->assertEquals(PartnerStatus::ACTIVE_PARTNER, $partner->status);
        $this->assertEquals('IT and programming', $partner->sector->name);
        $this->assertEquals('sckripttcie-inck', $partner->slug);


        $this->seePageIs(action(
            [AdminPartnersController::class, 'show'],
            ['partner' => $partner]
        ))
            ->click('Edit')
            ->seePageIs(action(
                [AdminPartnersController::class, 'edit'],
                ['partner' => $partner]
            ))
            ->type('Scriptcie Inc', 'name')
            ->press('Save')
             ->seePageIs(action(
                [AdminPartnersController::class, 'show'],
                ['partner' => $partner]
            ))
            ->see('Scriptcie Inc');

        $partner->refresh();
        $this->assertEquals($previous_logo_id, $partner->logo_media_id);
        $this
            ->see('Save note')
            ->see('Enable company profile')
            ->see('Add job opportunity')
            ->see('Enable footer');
    }
}
