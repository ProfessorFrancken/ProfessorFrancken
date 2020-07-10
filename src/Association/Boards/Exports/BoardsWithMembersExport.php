<?php

declare(strict_types=1);

namespace Francken\Association\Boards\Exports;

use Francken\Association\Boards\Board;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Plank\Mediable\MediableCollection;

class BoardsWithMembersExport implements WithMultipleSheets
{
    /**
     * @return Board[]|MediableCollection
     *
     * @psalm-return MediableCollection|array<array-key, Board>
     */
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
