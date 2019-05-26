<?php

declare(strict_types=1);

namespace Francken\Association\Boards\Imports;

use Francken\Association\Boards\BoardMember;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

final class BoardMembersImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows) : void
    {
        $rows->each(function ($row) : void {
            $row['name'] = $row['name'] ?? '';
            $row['photo'] = $row['photo'] ?? '';
            BoardMember::forceCreate($row->toArray());
        });
    }
}
