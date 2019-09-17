<?php

declare(strict_types=1);

namespace Francken\Association\Symposium\Http;

use Francken\Association\Symposium\Symposium;

final class AttendanceController
{
    public function index(Symposium $symposium)
    {
        $participants = $symposium->participants()
            ->orderBy('lastname', 'desc')
            ->where('is_spam', false)
            ->get();

        return view('admin.association.symposia.attendance', [
            'symposium' => $symposium,
            'participants' => $participants,
            'breadcrumbs' => [
                ['url' => action([AdminSymposiaController::class, 'index']), 'text' => 'Symposia'],
                ['url' => action([AdminSymposiaController::class, 'show'], $symposium->id), 'text' => $symposium->name],
                ['url' => action([static::class, 'index'], $symposium->id), 'text' => 'Attendance'],
            ]
        ]);
    }
}
