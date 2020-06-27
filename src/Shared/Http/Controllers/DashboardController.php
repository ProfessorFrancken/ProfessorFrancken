<?php

declare(strict_types=1);

namespace Francken\Shared\Http\Controllers;

class DashboardController extends Controller
{
    public function redirectToDashboard()
    {
        return redirect('/admin/overview');
    }

    public function overview()
    {
        return view('admin.overview', [
            'breadcrumbs' => [
                ['url' => action([self::class, 'overview']), 'text' => 'Adtministration'],
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
