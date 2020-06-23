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
    }
}
