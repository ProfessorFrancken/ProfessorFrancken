<?php

declare(strict_types=1);

namespace Francken\Association\Boards\Exports;

use Francken\Association\Boards\Board;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class BoardsWithMembersExport implements WithMultipleSheets
{
    public function collection()
    {
        return Board::all();
    }

    public function sheets() : array
    {
        return [
            'Boards' => new BoardsExport(),
            'Board members' => new BoardMembersExport()
        ];
    }
}
