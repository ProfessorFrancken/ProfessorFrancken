<?php

declare(strict_types=1);

namespace Francken\Association\Boards\Exports;

use Francken\Association\Boards\BoardMember;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class BoardMembersExport implements FromQuery, WithTitle, WithHeadings
{
    private const FIELDS = [
        'id',
        'board_id',
        'member_id',
        'name',
        'title',

        'board_member_status',
        'installed_at',
        'demissioned_at',
        'decharged_at',

        'created_at',
        'updated_at',
    ];

    public function query()
    {
        return BoardMember::query()->select(self::FIELDS);
    }

    public function title() : string
    {
        return 'Board members';
    }

    public function headings() : array
    {
        return self::FIELDS;
    }
}
