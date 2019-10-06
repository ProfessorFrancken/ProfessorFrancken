<?php

declare(strict_types=1);

namespace Francken\Features\Lustrum;

use Francken\Association\LegacyMember;
use Francken\Features\LoggedInAsAdmin;
use Francken\Features\TestCase;
use Francken\Lustrum\Adtchievement;
use Francken\Lustrum\EarnedAdtchievement;
use Francken\Lustrum\Http\Controllers\PirateCrewController;
use Francken\Lustrum\Pirate;
use Francken\Lustrum\PirateCrew;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PiratesFeature extends TestCase
{
    use DatabaseMigrations;
    use LoggedInAsAdmin;
    use DatabaseTransactions;

    /** @test */
    public function it_shows_an_overview_of_a_pirate_crew() : void
    {
        $adtchievement = Adtchievement::create([
            'title' => 'Being board',
            'description' => 'Do a board year',
            'points' => 33,
            'is_repeatable' => false,
            'is_team_effort' => false,
        ]);

        $blue_beards = PirateCrew::create([
            'name' => 'Blue beards',
            'slug' => 'blue-beard-pirates',
            'total_points' => 0,
        ]);

        $member = LegacyMember::findOrFail(1403);
        $pirate = $blue_beards->initiate($member);

        $adtchievement->earnBy($pirate);

        // dd(
        //     PirateCrew::with([
        //         'crewMembers',
        //         'earnedAdtchievements',
        //         'earnedAdtchievements.pirate',
        //         'earnedAdtchievements.adtchievement',
        //     ])->get()->toArray(),
        //     // Pirate::all()->toArray(),
        //     // EarnedAdtchievement::with(['pirate', 'adtchievement'])->get()->toArray(),
        // );

        $this->visit(
            action([PirateCrewController::class, 'index'], ['pirateCrew' => 'blue-beard-pirates'])
        );

        $this->assertResponseOk();

        $this->see('Blue beards')
            ->see('Pirate of the day')
            ->see('Mark')
            ->see('Mark Redeman')
            ->see('Crew adtchievements')
            ->see('Being board');
    }


    /** @test */
    public function a_member_can_be_added_to_a_crew() : void
    {
    }
}
