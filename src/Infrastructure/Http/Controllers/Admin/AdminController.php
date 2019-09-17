<?php

declare(strict_types=1);

namespace Francken\Infrastructure\Http\Controllers\Admin;

final class AdminController
{
    public function showPageIsUnavailable()
    {
        return view('admin.unavailable', [
            'breadcrumbs' => [
                ['url' => '', 'text' => 'Unavailable'],
            ]
        ]);
    }
}
