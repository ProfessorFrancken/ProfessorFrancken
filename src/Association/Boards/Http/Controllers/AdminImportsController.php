<?php

declare(strict_types=1);

namespace Francken\Association\Boards\Http\Controllers;

use Francken\Association\Boards\Imports\BoardsWithMembersImport;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;

final class AdminImportsController
{
    public function store(Request $request, BoardsWithMembersImport $import)
    {
        $file = $request->file('import');

        if ( ! ($file instanceof UploadedFile)) {
            return redirect(action([self::class, 'index']));
        }

        Excel::import($import, $file);

        return redirect(action([self::class, 'index']));
    }
}
