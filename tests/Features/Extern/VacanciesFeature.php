<?php

declare(strict_types=1);

namespace Francken\Features\Extern;

use Francken\Extern\Http\CareerController;
use Francken\Extern\Partner;
use Francken\Extern\SponsorOptions\Vacancy;
use Francken\Features\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class VacanciesFeature extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_shows_vacancies() : void
    {
        $vacancy = factory(Vacancy::class)->create([
            'partner_id' => factory(Partner::class)->create([
                'name' => 'S[ck]rip(t|t?c)ie In[ck]'
            ])->id,
        ]);

        $this->visit(action([CareerController::class, 'jobs']))
            ->see($vacancy->title);
    }

    /** @test */
    public function it_allows_filtering_vacancies_based_on_partners_with_vacancies() : void
    {
        $partnerWithoutVacancy = factory(Partner::class)->create();

        $selectedPartner = factory(Partner::class)->create();
        $vacancy = factory(Vacancy::class)->create([
            'partner_id' => $selectedPartner->id,
        ]);

        $otherVacancy = factory(Vacancy::class)->create();

        $this->visit(action([CareerController::class, 'jobs']))
            ->see($vacancy->title)
            ->see($vacancy->partner->name)
            ->see($otherVacancy->title)
            ->see($otherVacancy->partner->name)
            ->dontSee($partnerWithoutVacancy->name);

        $this->type($vacancy->title, 'title')
             ->select($selectedPartner->id, 'partner_id')
             ->select($vacancy->sector_id, 'sector_id')
             ->select($vacancy->type, 'job_type')
            ->press('Apply filters')
            ->see($vacancy->title)
            ->dontSee($otherVacancy->title);
    }
}
