<?php

declare(strict_types=1);

namespace Francken\Shared\Http\Controllers;

use DB;

class DashboardController extends Controller
{
    public function redirectToDashboard()
    {
        return redirect('/admin/overview');
    }

    public function overview()
    {
        $events = DB::table('event_store')->orderBy('recorded_on', 'desc')->take(25)->get();

        return view('admin.overview', [
            'events' => $events,
            'breadcrumbs' => [
                ['url' => action([self::class, 'overview']), 'text' => 'Dashboard'],
            ]
        ]);
    }

    public function analytics()
    {
        return view('admin.analytics');
    }

    public function export()
    {
        return view('admin.export');
    }
}
