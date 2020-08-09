<?php

declare(strict_types=1);

namespace Francken\Features\Association\Activities;

use Francken\Association\Activities\Activity;
use Francken\Association\Activities\Comment;
use Francken\Association\Activities\Http\ActivitiesController;
use Francken\Association\Activities\Http\CommentsController;
use Francken\Auth\Account;
use Francken\Features\TestCase;

class CommentsFeature extends TestCase
{
    /** @test */
    public function it_allows_a_member_to_comment_to_an_activity() : void
    {
        $activity = factory(Activity::class)->create();

        $account = factory(Account::class)->create();
        $this->actingAs($account)
            ->visit(action([ActivitiesController::class, 'show'], ['activity' => $activity]))
            ->type('hoi', 'content')
            ->press('Comment');

        $this->assertCount(1, $activity->comments);
    }

    /** @test */
    public function it_allows_a_member_to_change_their_comment() : void
    {
        $activity = factory(Activity::class)->create();

        $account = factory(Account::class)->create();
        $comment = factory(Comment::class)->create([
            'activity_id' => $activity->id,
            'member_id' => $account->member_id,
        ]);

        $this->actingAs($account)
            ->visit(action(
                [CommentsController::class, 'edit'],
                ['activity' => $activity, 'comment' => $comment]
            ))
            ->type('Hoi', 'content')
            ->press('Save')
            ->seePageIs(
                action(
                    [ActivitiesController::class, 'show'],
                    ['activity' => $activity]
                )
            );

        $comment->refresh();
        $this->assertEquals('Hoi', $comment->content);
    }

    /** @test */
    public function it_allows_a_member_to_remove_their_comment() : void
    {
        $activity = factory(Activity::class)->create();
        $account = factory(Account::class)->create();
        $comment = factory(Comment::class)->create([
            'activity_id' => $activity->id,
            'member_id' => $account->member_id,
        ]);

        $this->actingAs($account)
            ->visit(action(
                [CommentsController::class, 'edit'],
                ['activity' => $activity, 'comment' => $comment]
            ))
            ->press('Remove comment')
            ->seePageIs(
                action(
                    [ActivitiesController::class, 'show'],
                    ['activity' => $activity]
                )
            );

        $this->assertCount(0, $activity->comments);
    }
}
