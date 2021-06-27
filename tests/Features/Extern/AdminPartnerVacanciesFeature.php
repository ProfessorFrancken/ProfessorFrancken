<?php

declare(strict_types=1);

namespace Francken\Features\Extern;

use Francken\Extern\Http\AdminPartnersController;
use Francken\Extern\Http\AdminVacanciesController;
use Francken\Extern\Partner;
use Francken\Extern\PartnerStatus;
use Francken\Features\LoggedInAsAdmin;
use Francken\Features\TestCase;
use Illuminate\Support\Str;

class AdminPartnerVacanciesFeature extends TestCase
{
    use LoggedInAsAdmin;

    /** @test */
    public function a_partners_vacancies_can_be_added() : void
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
            ->click('Add vacancy')
            ->seePageIs((action(
                [AdminVacanciesController::class, 'create'],
                ['partner' => $partner]
            )))
             ->type('Wizard', 'title')
             ->type('Doing wizardry things', 'description')
             ->type('https://scriptcie.nl/wizards', 'vacancy_url')
             ->select("Fulltime", 'type')
            ->press('Add vacancy')
             ->seePageIs((action(
                 [AdminPartnersController::class, 'show'],
                 ['partner' => $partner]
             )))
            ->see('Wizard');

        $vacancies = $partner->vacancies;
        $this->assertCount(1, $vacancies);

        $this->visit(action(
            [AdminVacanciesController::class, 'edit'],
            ['partner' => $partner, 'vacancy' => $vacancies[0]]
        ))
             ->type('Ninja', 'title')
             ->type('Doing ninja things', 'description')
             ->type('https://scriptcie.nl/ninjas', 'vacancy_url')
             ->select("Internship", 'type')
            ->press('Save vacancy')
             ->seePageIs((action(
                 [AdminPartnersController::class, 'show'],
                 ['partner' => $partner]
             )))
            ->see('Ninja');
    }
}
