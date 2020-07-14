<?php

declare(strict_types=1);

namespace Francken\Features\Extern;

use DateTimeImmutable;
use Francken\Extern\ContactDetails;
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
        $sectorId = Sector::where('name', 'IT and programming')
            ->firstOrFail()
            ->id;

        $this->visit(action([AdminPartnersController::class, 'index']))
            ->click('Add a partner')
            ->see('Add a new partner')
            ->type('S[ck]rip(t|t?c)ie In[ck]', 'name')
            ->select($sectorId, 'sector_id')
            ->type('https://scriptcie.nl', 'homepage_url')
            ->type('https://scriptcie.nl?referal=francken', 'referral_url')
            ->type('2021-07-14', 'last_contract_ends_at')
            ->select(PartnerStatus::ACTIVE_PARTNER, 'status')
            ->attach(UploadedFile::fake()->image('scriptcie.png'), 'logo')
            ->type('kathinka@scriptcie.nl', 'email')
            ->press('Add');

        $partner = Partner::where('name', 'S[ck]rip(t|t?c)ie In[ck]')->firstOrFail();
        $previousLogoId = $partner->logo_media_id;

        $this->assertEquals('S[ck]rip(t|t?c)ie In[ck]', $partner->name);
        $this->assertEquals('https://scriptcie.nl', $partner->homepage_url);
        $this->assertEquals('https://scriptcie.nl?referal=francken', $partner->referral_url);
        $this->assertEquals(PartnerStatus::ACTIVE_PARTNER, $partner->status);
        $this->assertEquals('IT and programming', $partner->sector->name);
        $this->assertEquals('sckripttcie-inck', $partner->slug);
        $this->assertEquals(DateTimeImmutable::createFromFormat('!Y-m-d', '2021-07-14'), $partner->last_contract_ends_at);

        // Contact details can be addded
        $this->assertEquals('kathinka@scriptcie.nl', $partner->contactDetails->email);

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
            ->type('Francken', 'department')
            ->press('Save')
             ->seePageIs(action(
                [AdminPartnersController::class, 'show'],
                ['partner' => $partner]
            ))
            ->see('Scriptcie Inc');

        $partner->refresh();

        $this->assertEquals('Francken', $partner->contactDetails->department);
        $this->assertEquals(1, ContactDetails::count());
        $this->assertEquals($previousLogoId, $partner->logo_media_id);
        $this
            ->see('Save note')
            ->see('Enable company profile')
            ->see('Add vacancy')
            ->see('Enable footer');
    }
}
