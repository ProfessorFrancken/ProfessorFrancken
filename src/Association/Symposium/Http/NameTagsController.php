<?php

declare(strict_types=1);

namespace Francken\Association\Symposium\Http;

use Francken\Association\Symposium\Symposium;

final class NameTagsController
{
    public function index(Symposium $symposium)
    {
        $participants = $symposium->participants()
            ->orderBy('lastname', 'desc')
            ->where('is_spam', false)
            ->get();

        return view('admin.association.symposia.name-tags', [
            'symposium' => $symposium,
            'participants' => $participants,
            'breadcrumbs' => [
                ['url' => action([AdminSymposiaController::class, 'index']), 'text' => 'Symposia'],
                ['url' => action([AdminSymposiaController::class, 'show'], $symposium->id), 'text' => $symposium->name],
                ['url' => action([static::class, 'index'], $symposium->id), 'text' => 'Name tags'],
            ]
        ]);
    }
}
