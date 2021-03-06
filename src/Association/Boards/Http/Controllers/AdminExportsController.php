<?php

declare(strict_types=1);

namespace Francken\Association\Boards\Http\Controllers;

use Francken\Association\Boards\Exports\BoardsWithMembersExport;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

final class AdminExportsController
{
    public function index(BoardsWithMembersExport $export) : BinaryFileResponse
    {
        return Excel::download($export, 'boards.xlsx');
    }
}
