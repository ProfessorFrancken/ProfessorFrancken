<?php

declare(strict_types=1);

namespace Francken\Association\Members\Exports;

use Francken\Association\LegacyMember;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class MembersExport implements FromCollection, WithTitle, WithHeadings
{
    private const FIELDS = [
        'id',
        'voornaam',
        'tussenvoegsel',
        'achternaam',

        'start_lidmaatschap',
        'einde_lidmaatschap',
        'rekeningnummer',
        'erelid'
    ];


    /** @param Builder<LegacyMember> $members */
    public function __construct(private Builder $members)
    {
    }

    /**
     * @return Collection<int, LegacyMember>
     */
    public function collection()
    {
        return $this->members->select(self::FIELDS)->get();
    }

    public function title() : string
    {
        return 'Members';
    }

    public function headings() : array
    {
        return self::FIELDS;
    }
}
