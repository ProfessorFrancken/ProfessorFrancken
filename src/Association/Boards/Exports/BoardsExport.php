<?php

declare(strict_types=1);

namespace Francken\Association\Boards\Exports;

use Francken\Association\Boards\Board;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class BoardsExport implements FromQuery, WithTitle, WithHeadings
{
    private const FIELDS = [
        'id',
        'name',
        'photo',
        'photo_position',

        'installed_at',
        'demissioned_at',
        'decharged_at',

        'created_at',
        'updated_at'
    ];

    public function query()
    {
        return Board::query()->select(self::FIELDS);
    }

    public function title() : string
    {
        return 'Boards';
    }

    public function headings(): array
    {
        return self::FIELDS;
    }
}

