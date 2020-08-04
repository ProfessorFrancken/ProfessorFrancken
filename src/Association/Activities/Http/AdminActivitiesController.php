<?php

declare(strict_types=1);

namespace Francken\Association\Activities\Http;

use Francken\Association\Activities\Activity;
use Francken\Association\LegacyMember;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final class AdminActivitiesController
{
    public function index() : View
    {
        $activities = Activity::query()
            ->with(['signUpSettings'])
            ->orderBy('start_date', 'desc')
            ->paginate(50);

        return view('admin.association.activities.index')
            ->with([
                'activities' => $activities,
                'breadcrumbs' => [
                    ['url' => action([self::class, 'index']), 'text' => 'Activities'],
                ]
            ]);
    }

    public function show(Activity $activity) : View
    {
        return view('admin.association.activities.show')
            ->with([
                'activity' => $activity,
                'breadcrumbs' => [
                    ['url' => action([self::class, 'index']), 'text' => 'Activities'],
                    ['url' => action([static::class, 'show'], ['activity' => $activity]), 'text' => $activity->name],
                ]
            ]);
    }

    public function create() : View
    {
        return view('admin.association.activities.create')
            ->with([
                'activity' => new Activity(),
                'members' => LegacyMember::autocomplete(),
                'breadcrumbs' => [
                    ['url' => action([self::class, 'index']), 'text' => 'Activities'],
                    ['url' => action([static::class, 'create']), 'text' => 'Create'],
                ]
            ]);
    }

    public function edit(Activity $activity) : View
    {
        return view('admin.association.activities.edit')
            ->with([
                'activity' => $activity,
                'members' => LegacyMember::autocomplete(),
                'breadcrumbs' => [
                    ['url' => action([self::class, 'index']), 'text' => 'Activities'],
                    ['url' => action([static::class, 'show'], ['activity' => $activity]), 'text' => $activity->name],
                    ['url' => action([static::class, 'edit'], ['activity' => $activity]), 'text' => 'Edit'],
                ]
            ]);
    }

    public function update(Activity $activity) : RedirectResponse
    {
        return redirect()->action([self::class, 'show'], ['activity' => $activity]);
    }
}
