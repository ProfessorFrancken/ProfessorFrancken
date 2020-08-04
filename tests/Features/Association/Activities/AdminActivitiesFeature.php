<?php

declare(strict_types=1);

namespace Francken\Features\Association\Activities;

use Francken\Association\Activities\Activity;
use Francken\Association\Activities\Http\AdminActivitiesController;
use Francken\Features\LoggedInAsAdmin;
use Francken\Features\TestCase;

class AdminActivitiesFeature extends TestCase
{
    use LoggedInAsAdmin;

    /** @test */
    public function a_list_of_activities_is_shown() : void
    {
        $activity = factory(Activity::class)->create();

        $this->visit(action([AdminActivitiesController::class, 'index']))
            ->see($activity->name);

        $this->assertResponseOk();
    }

    /** @test */
    public function a_shows_an_activity() : void
    {
        $activity = factory(Activity::class)->create();

        $this->visit(action([AdminActivitiesController::class, 'show'], ['activity' => $activity]))
            ->see($activity->name);

        $this->assertResponseOk();
    }

    /** @test */
    public function a_edits_an_activity() : void
    {
        $activity = factory(Activity::class)->create();

        $this->visit(action([AdminActivitiesController::class, 'edit'], ['activity' => $activity]))
            ->see($activity->name)
             ->type('Something else', 'name')
             ->press('Save')
                                                                                    ->assertResponseOk();

        $activity->refresh();
        $this->assertNotEquals('Something else', $activity->name);
    }
}
