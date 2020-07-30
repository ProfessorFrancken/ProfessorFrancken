<?php

declare(strict_types=1);

namespace Francken\Association\Committees\Exports;

use Francken\Association\Boards\Board;
use Francken\Association\Committees\Committee;
use Francken\Association\Committees\CommitteeMember;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Webmozart\Assert\Assert;

class CommitteeMembersExport implements FromCollection, WithTitle, WithHeadings, WithMapping
{
    private Board $board;

    public function __construct(Board $board)
    {
        $this->board = $board;
    }

    public function title() : string
    {
        return 'Committee members';
    }

    public function headings() : array
    {
        return [
            'Member id',
            'Committee id',
            'Member',
            'Fucntion',
            'Committee name',
            'Installed at',
            'Decharged at',
        ];
    }

    public function collection() : Collection
    {
        return $this->board
            ->hasManyThrough(CommitteeMember::class, Committee::class)
            ->with(['member', 'committee'])
            ->get();
    }

    public function map($committeeMember) : array
    {
        Assert::isInstanceOf($committeeMember, CommitteeMember::class);

        $member = $committeeMember->member;
        $committee = $committeeMember->committee;

        return [
            'member_id' => $committeeMember->member_id,
            'committee_id' => $committeeMember->committee_id,
            'member' => $member->fullname,
            'function' => $committeeMember->function,
            'committee' => $committee->name,
            'installed_at' => $committeeMember->installed_at,
            'decharged_at' => $committeeMember->decharged_at,
        ];
    }
}
