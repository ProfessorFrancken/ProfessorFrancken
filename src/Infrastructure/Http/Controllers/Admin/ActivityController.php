<?php

declare(strict_types=1);

namespace Francken\Infrastructure\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Francken\Infrastructure\Http\Controllers\Controller;

use Francken\Domain\Activities\ActivityRepository;
use Francken\Domain\Activities\Activity;
use Francken\Domain\Activities\ActivityId;
use Francken\Domain\Activities\Location;
use Francken\Domain\Activities\Schedule;

class ActivityController extends Controller
{
    use ValidatesRequests;

    public function index()
    {
        $date = new \DateTime();
        return view('admin.activity.index',
            [
                'title' => 'C&C',
                'description' => '',
                'location' => 'Franckenkamer',
                'date' => $date->format('d/m/Y'),
                'time' => '16:00'
            ]);
    }

    public function store(Request $request, ActivityRepository $repo)
    {
        $this->validate($request, [
            'title' => 'required|min:3',
            'location' => 'required',
            'date' => 'required|date_format:d/m/Y',
            'time' => 'date_format:H:i'
        ]);

        $title = $request->get('title');
        $description = $request->get('description');
        $location = Location::fromNameAndAddress($request->get('location'));
        $date = \DateTimeImmutable::createFromFormat('d/m/Y H:i', $request->get('date') . $request->get('time'));

        // TODO: add option with end time.
        $schedule = Schedule::withStartTime($date);

        $activity = Activity::plan(
            ActivityId::generate(),
            $title,
            $description,
            $schedule,
            $location,
            Activity::SOCIAL);

        $repo->save($activity);

        return redirect('/admin/activity');
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(Request $req, string $id)
    {
    }

    public function destroy($id)
    {
    }
}
