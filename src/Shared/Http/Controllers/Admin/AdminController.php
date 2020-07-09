<?php

declare(strict_types=1);

namespace Francken\Shared\Http\Controllers\Admin;

use Illuminate\View\View;

final class AdminController
{
    public function showPageIsUnavailable() : View
    {
        return view('admin.unavailable', [
            'breadcrumbs' => [
                ['url' => '', 'text' => 'Unavailable'],
            ]
        ]);
    }
}
