<?php

declare(strict_types=1);

namespace Francken\Shared\Http\Controllers\Admin;

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
