<?php

declare(strict_types=1);

namespace Francken\infrastructure\Http\Controllers\Admin;

final class AdminController
{
    public function showPageIsUnavailable()
    {
        return view('admin.unavailable');
    }
}
