<?php

declare(strict_types=1);

namespace Francken\Features\Association\Activities;

use Francken\Association\Activities\Activity;
use Francken\Association\Activities\Http\AdminActivitiesController;
use Francken\Association\Activities\Http\AdminSignUpsController;
use Francken\Association\Activities\SignUp;
use Francken\Association\Activities\SignUpSettings;
use Francken\Association\LegacyMember;
use Francken\Features\LoggedInAsAdmin;
use Francken\Features\TestCase;

class AdminSignUpsFeature extends TestCase
{
    use LoggedInAsAdmin;

    /** @test */
    public function it_allows_a_board_member_to_sign_up_a_member() : void
    {
        $activity = factory(Activity::class)->create();
        factory(SignUpSettings::class)->create([
            'activity_id' => $activity->id,
            'ask_for_dietary_wishes' => true,
            'ask_for_drivers_license' => true,
        ]);

        $member = factory(LegacyMember::class)->create();

        $this->visit(action([AdminActivitiesController::class, 'show'], ['activity' => $activity]))
            ->see($activity->name)
            ->click('Add sign up')
            ->type($member->id, 'member_id')
            ->type('Kip & Ketel', 'dietary_wishes')
            ->uncheck('has_drivers_license')
            ->type(1, 'plus_ones')
            ->type('Hoi', 'notes')
            ->press('Sign up')
            ->seePageIs(action([AdminActivitiesController::class, 'show'], ['activity' => $activity]));

        $this->assertResponseOk();
        $this->assertCount(1, $activity->signUps);
    }

    /** @test */
    public function it_allows_changing_a_sign_up() : void
    {
        $activity = factory(Activity::class)->create();
        factory(SignUpSettings::class)->create([
            'activity_id' => $activity->id,
            'ask_for_dietary_wishes' => true,
            'ask_for_drivers_license' => true,
        ]);
        $signUp = factory(SignUp::class)->create([
            'activity_id' => $activity->id,
            'has_drivers_license' => true
        ]);

        $this->visit(action([AdminSignUpsController::class, 'edit'], ['activity' => $activity, 'sign_up' => $signUp]))
            ->see($activity->name)
            ->type('Kip & Ketel', 'dietary_wishes')
            ->uncheck('has_drivers_license')
            ->type(1, 'plus_ones')
            ->type('Hoi', 'notes')
            ->press('Save')
            ->seePageIs(action([AdminActivitiesController::class, 'show'], ['activity' => $activity]));

        $this->assertResponseOk();
        $signUp->refresh();
        $this->assertEquals('Kip & Ketel', $signUp->dietary_wishes);
        $this->assertEquals(1, $signUp->plus_ones);
        $this->assertEquals('Hoi', $signUp->notes);
        $this->assertFalse($signUp->has_drivers_license);
    }

    /** @test */
    public function it_allows_removing_a_sign_up() : void
    {
        $activity = factory(Activity::class)->create();
        factory(SignUpSettings::class)->create([
            'activity_id' => $activity->id,
            'ask_for_dietary_wishes' => true,
            'ask_for_drivers_license' => true,
        ]);
        $signUp = factory(SignUp::class)->create([
            'activity_id' => $activity->id,
            'has_drivers_license' => true
        ]);

        $this->visit(action([AdminSignUpsController::class, 'edit'], ['activity' => $activity, 'sign_up' => $signUp]))
             ->press('here')
             ->seePageIs(action([AdminActivitiesController::class, 'show'], ['activity' => $activity]));

        $this->assertCount(0, $activity->signUps);
    }
}
