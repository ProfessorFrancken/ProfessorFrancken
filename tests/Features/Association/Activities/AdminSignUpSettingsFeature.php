<?php

declare(strict_types=1);

namespace Francken\Features\Association\Activities;

use Francken\Association\Activities\Activity;
use Francken\Association\Activities\Http\AdminActivitiesController;
use Francken\Association\Activities\Http\AdminSignUpSettingsController;
use Francken\Association\Activities\SignUpSettings;
use Francken\Features\LoggedInAsAdmin;
use Francken\Features\TestCase;

class AdminSignUpSettingsFeature extends TestCase
{
    use LoggedInAsAdmin;

    /** @test */
    public function it_allows_adding_sign_up_settings_to_an_activity() : void
    {
        $activity = factory(Activity::class)->create();

        $this->visit(action([AdminSignUpSettingsController::class, 'create'], ['activity' => $activity]))
            ->see($activity->name)
            ->type('2020-01-01 16:00:00', 'deadline_at')
            ->type(33, 'max_sign_ups')
            ->type(3333, 'costs_per_person')
            ->type(3, 'max_plus_ones_per_member')
            ->check('ask_for_dietary_wishes')
            ->check('ask_for_drivers_license')
            ->press('Add sign up settings');

        $this->assertResponseOk();
        $this->assertNotNull($activity->signUpSettings);
    }

    /** @test */
    public function it_allows_updating_the_sign_up_settings_of_an_activity() : void
    {
        $activity = factory(Activity::class)->create();
        $signUpSettings = factory(SignUpSettings::class)->create([
            'activity_id' => $activity->id
        ]);

        $this->visit(
            action(
                [AdminSignUpSettingsController::class, 'edit'],
                ['activity' => $activity]
            )
        )
            ->see($activity->name)
            ->type('2020-01-01 16:00:00', 'deadline_at')
            ->type(33, 'max_sign_ups')
            ->type(3333, 'costs_per_person')
            ->type(3, 'max_plus_ones_per_member')
            ->check('ask_for_dietary_wishes')
            ->check('ask_for_drivers_license')
            ->press('Save sign up settings')
            ->seePageIs(
                action(
                    [AdminActivitiesController::class, 'show'],
                    ['activity' => $activity]
                )
            );

        $this->assertResponseOk();
        $signUpSettings->refresh();
        $this->assertEquals(3333, $signUpSettings->costs_per_person);
    }

    /** @test */
    public function it_allows_removing_the_sign_up_settings_of_an_activity() : void
    {
        $activity = factory(Activity::class)->create();
        factory(SignUpSettings::class)->create([
            'activity_id' => $activity->id
        ]);

        $this->delete(
            action(
                [AdminSignUpSettingsController::class, 'destroy'],
                ['activity' => $activity]
            )
        );
        $this->assertResponseStatus(302);

        $activity->refresh();
        $this->assertNull($activity->signUpSettings);
    }
}
