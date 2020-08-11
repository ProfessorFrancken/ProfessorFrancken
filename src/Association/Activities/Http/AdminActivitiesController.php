<?php

declare(strict_types=1);

namespace Francken\Association\Activities\Http;

use Francken\Association\Activities\Activity;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use SimpleSoftwareIO\QrCode\Generator;

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

    public function show(Activity $activity, Generator $qrCodeGenerator) : View
    {
        $qrCode = base64_encode($this->qrCode($activity, $qrCodeGenerator));

        return view('admin.association.activities.show')
            ->with([
                'activity' => $activity,
                'qrCode' => $qrCode,
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

    private function qrCode(Activity $activity, Generator $qrCodeGenerator) : string
    {
        $qrCodeImage = $qrCodeGenerator
            ->format('png')
            ->size(330)
            ->generate(
                action(
                    [ActivitiesController::class, 'redirect'],
                    ['activity' => $activity]
                )
            );

        return is_string($qrCodeImage) ? $qrCodeImage : '';
    }
}
