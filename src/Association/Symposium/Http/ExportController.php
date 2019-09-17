<?php

declare(strict_types=1);

namespace Francken\Association\Symposium\Http;

use Francken\Association\Symposium\Exports\SymposiumExport;
use Francken\Association\Symposium\Symposium;
use Maatwebsite\Excel\Excel;

final class ExportController
{
    public function index(Excel $excel, Symposium $symposium)
    {
        return $excel->download(
            new SymposiumExport($symposium),
            str_slug($symposium->name) . '.xlsx'
        );

        $symposium->load(['participants' => function ($query) {
            return $query->orderBy('lastname', 'asc');
        }]);

        return view('admin.association.symposia.attendance', [
            'symposium' => $symposium,
            'breadcrumbs' => [
                ['url' => action([AdminSymposiaController::class, 'index']), 'text' => 'Symposia'],
                ['url' => action([AdminSymposiaController::class, 'show'], $symposium->id), 'text' => $symposium->name],
                ['url' => action([static::class, 'index'], $symposium->id), 'text' => 'Attendance'],
            ]
        ]);
    }
}
