<?php

declare(strict_types=1);

namespace Francken\Association\Activities\Http;

use Francken\Association\Activities\Activity;
use Francken\Association\Activities\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class CommentsController
{
    public function store(Request $request, Activity $activity) : RedirectResponse
    {
        $activity->comments()->save(
            new Comment([
                'member_id' => $request->user()->member_id,
                'content' => $request->input('content')
            ])
        );

        return redirect()->action([ActivitiesController::class, 'show'], ['activity' => $activity]);
    }

    public function edit(Request $request, Activity $activity, Comment $comment) : View
    {
        $account = $request->user();

        return view('association.activities.comments.edit', [
            'activity' => $activity,
            'comment' => $comment,
            'account' => $account,
            'searchTimeRange' => false,
            'breadcrumbs' => [
                ['url' => '/association/', 'text' => 'Association'],
                ['url' => action([ActivitiesController::class, 'index']), 'text' => 'Activities'],
                ['url' => action([ActivitiesController::class, 'show'], ['activity' => $activity]), 'text' => $activity->name],
                ['url' => action([self::class, 'edit'], ['activity' => $activity, 'comment' => $comment]), 'text' => 'Edit comment'],
            ],
        ]);
    }

    public function update(Request $request, Activity $activity, Comment $comment) : RedirectResponse
    {
        $comment->update(['content' => $request->input('content')]);

        return redirect()->action([ActivitiesController::class, 'show'], ['activity' => $activity]);
    }

    public function destroy(Activity $activity, Comment $comment) : RedirectResponse
    {
        $comment->delete();

        return redirect()->action([ActivitiesController::class, 'show'], ['activity' => $activity]);
    }
}
