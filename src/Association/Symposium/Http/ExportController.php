<?php

declare(strict_types=1);

namespace Francken\Association\Symposium\Http;

use Francken\Association\Symposium\Exports\SymposiumExport;
use Francken\Association\Symposium\Symposium;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Excel;

final class ExportController
{
    public function index(Excel $excel, Symposium $symposium)
    {
        return $excel->download(
            new SymposiumExport($symposium),
            Str::slug($symposium->name) . '.xlsx'
        );
    }
}
