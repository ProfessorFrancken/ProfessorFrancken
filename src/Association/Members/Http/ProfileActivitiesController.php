<?php

declare(strict_types=1);

namespace Francken\Association\Members\Http;

use Francken\Association\Activities\Activity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class ProfileActivitiesController
{
    public function index(Request $request) : View
    {
        $member = $request->user()->member;

        $activities = Activity::query()
            ->whereHas('signUps', fn (Builder $query) => $query->where('member_id', $member->id))
            ->orderBy('start_date', 'desc')
            ->paginate(20);

        return view('profile.activities.index')
            ->with([
                'member' => $member,
                'activities' => $activities,
                'breadcrumbs' => [
                    ['url' => action([ProfileController::class, 'index']), 'text' => 'Profile'],
                    ['url' => action([self::class, 'index']), 'text' => 'Activities'],
                ]
            ]);
    }
}
