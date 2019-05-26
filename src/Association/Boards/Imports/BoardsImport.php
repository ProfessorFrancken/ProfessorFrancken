<?php

declare(strict_types=1);

namespace Francken\Association\Boards\Imports;

use Francken\Association\Boards\Board;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

final class BoardsImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows) : void
    {
        $rows->each(function ($row) : void {
            $row['photo_position'] = $row['photo_position'] ?? '';
            $row['photo'] = $row['photo'] ?? '';
            $row['name'] = $row['name'] ?? '';
            Board::forceCreate($row->toArray());
        });
    }
}
