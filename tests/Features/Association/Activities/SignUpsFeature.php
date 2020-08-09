<?php

declare(strict_types=1);

namespace Francken\Features\Association\Activities;

use DateTimeImmutable;
use Francken\Association\Activities\Activity;
use Francken\Association\Activities\Http\ActivitiesController;
use Francken\Association\Activities\Http\SignUpsController;
use Francken\Association\Activities\SignUp;
use Francken\Association\Activities\SignUpSettings;
use Francken\Auth\Account;
use Francken\Features\TestCase;

class SignUpsFeature extends TestCase
{
    /** @test */
    public function it_allows_a_member_to_sign_up_to_an_activity() : void
    {
        $tomorrow = new DateTimeImmutable('tomorrow +1day');

        $activity = factory(Activity::class)->create();
        factory(SignUpSettings::class)->create([
            'activity_id' => $activity->id,
            'deadline_at' => $tomorrow
        ]);

        $account = factory(Account::class)->create();
        $this->actingAs($account)
            ->visit(action([ActivitiesController::class, 'show'], ['activity' => $activity]))
            ->press('Sign up');
        $this->assertCount(1, $activity->signUps);
    }

    /** @test */
    public function it_does_not_allow_a_member_to_sign_up_twice_to_an_activity() : void
    {
        $activity = factory(Activity::class)->create();
        factory(SignUpSettings::class)->create([
            'activity_id' => $activity->id,
            'ask_for_dietary_wishes' => true,
            'ask_for_drivers_license' => true,
        ]);

        $account = factory(Account::class)->create();
        factory(SignUp::class)->create([
            'activity_id' => $activity->id,
            'member_id' => $account->member_id,
        ]);

        $this->actingAs($account)
             ->visit(action([ActivitiesController::class, 'show'], ['activity' => $activity]))
            ->dontSee('Sign up for');
    }

    /** @test */
    public function it_has_a_limit_to_the_amount_of_plus_ones_a_member_can_bring() : void
    {
        $activity = factory(Activity::class)->create();
        factory(SignUpSettings::class)->create([
            'activity_id' => $activity->id,
            'max_sign_ups' => 33,
        ]);
        $account = factory(Account::class)->create();
        $this->actingAs($account)
            ->visit(action([ActivitiesController::class, 'show'], ['activity' => $activity]))
            ->type(33, 'plus_ones')
            ->press('Sign up');

        $this->assertCount(0, $activity->signUps);
    }

    /** @test */
    public function it_allows_a_member_to_change_their_sign_up() : void
    {
        $activity = factory(Activity::class)->create();
        factory(SignUpSettings::class)->create([
            'activity_id' => $activity->id,
            'max_sign_ups' => 34,
            'max_plus_ones_per_member' => null
        ]);

        $account = factory(Account::class)->create();
        $signUp = factory(SignUp::class)->create([
            'activity_id' => $activity->id,
            'member_id' => $account->member_id,
            'plus_ones' => 10
        ]);

        $this->actingAs($account)
            ->visit(action(
                [SignUpsController::class, 'edit'],
                ['activity' => $activity, 'sign_up' => $signUp]
            ))
            ->type(33, 'plus_ones')
            ->press('Save')
            ->seePageIs(
                action(
                    [ActivitiesController::class, 'show'],
                    ['activity' => $activity]
                )
            );

        $signUp->refresh();
        $this->assertEquals(33, $signUp->plus_ones);
    }

    /** @test */
    public function it_allows_a_member_to_cancel_their_sign_up() : void
    {
        $activity = factory(Activity::class)->create();
        factory(SignUpSettings::class)->create([
            'activity_id' => $activity->id,
            'max_sign_ups' => 34,
            'max_plus_ones_per_member' => null
        ]);

        $account = factory(Account::class)->create();
        $signUp = factory(SignUp::class)->create([
            'activity_id' => $activity->id,
            'member_id' => $account->member_id,
            'plus_ones' => 10
        ]);

        $this->actingAs($account)
            ->visit(action(
                [SignUpsController::class, 'edit'],
                ['activity' => $activity, 'sign_up' => $signUp]
            ))
            ->press('Cancel your sign up')
            ->seePageIs(
                action(
                    [ActivitiesController::class, 'show'],
                    ['activity' => $activity]
                )
            );

        $this->assertEquals(0, $activity->total_sign_ups);
    }
}
