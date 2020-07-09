<?php

declare(strict_types=1);

namespace Francken\Association\Boards\Http\Controllers;

use Francken\Association\Boards\Imports\BoardsWithMembersImport;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Importer;

final class AdminImportsController
{
    public function store(Request $request, BoardsWithMembersImport $import, Importer $excel)
    {
        $file = $request->file('import');

        if ( ! ($file instanceof UploadedFile)) {
            return redirect(action([self::class, 'index']));
        }

        $excel->import($import, $file);

        return redirect(action([AdminBoardsController::class, 'index']));
    }
}
