<?php

declare(strict_types=1);

namespace Francken\Features\Extern;

use Francken\Extern\Http\AdminPartnerContactsController;
use Francken\Extern\Http\AdminPartnersController;
use Francken\Extern\Partner;
use Francken\Extern\PartnerStatus;
use Francken\Features\LoggedInAsAdmin;
use Francken\Features\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;

class AdminPartnerContactsFeature extends TestCase
{
    use DatabaseMigrations;
    use LoggedInAsAdmin;

    /** @test */
    public function a_partners_logo_can_be_listed_in_the_contact() : void
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
            ->click('Add contact')
            ->seePageIs((action(
                [AdminPartnerContactsController::class, 'create'],
                ['partner' => $partner]
            )))
            ->select('male', 'gender')
             ->type('Corporate Recruiter', 'position')
             ->type('John', 'firstname')
             ->type('Snow', 'surname')
             ->type('john@scriptcie.nl', 'email')
            ->attach(UploadedFile::fake()->image('john.png'), 'photo')
            ->press('Add contact')
             ->seePageIs((action(
                [AdminPartnersController::class, 'show'],
                ['partner' => $partner]
            )))
            ->see('John Snow')
            ->click('Edit contact')
            ->see('john@scriptcie.nl')
            ->select('female', 'gender')
             ->type('Arya', 'firstname')
             ->type('Stark', 'surname')
            ->press('Save contact');

        $this->assertCount(1, $partner->contacts);
    }
}
