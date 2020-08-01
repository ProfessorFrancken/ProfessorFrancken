<?php

declare(strict_types=1);

namespace Francken\Association\Activities\Http;

use Francken\Association\Activities\ActivitiesRepository;
use Francken\Association\LegacyMember;
use Francken\Shared\Markdown\ContentCompiler;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final class AdminActivitiesController
{
    public function index(ActivitiesRepository $repo) : View
    {
        $activities = $repo->all();

        return view('admin.association.activities.index')
            ->with([
                'activities' => $activities,
                'breadcrumbs' => [
                    ['url' => action([self::class, 'index']), 'text' => 'Activities'],
                ]
            ]);
    }

    public function show(ActivitiesRepository $repo, string $activity) : View
    {
        $activity = $repo->all()->first(fn ($a) => $a->id == $activity);

        return view('admin.association.activities.show')
            ->with([
                'members' => LegacyMember::autocomplete(),
                'activity' => $activity,
                'breadcrumbs' => [
                    ['url' => action([self::class, 'index']), 'text' => 'Activities'],
                    ['url' => action([static::class, 'show'], ['activity' => $activity]), 'text' => $activity->name()],
                ]
            ]);
    }
}
