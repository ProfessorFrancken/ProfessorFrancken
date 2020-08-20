<?php

declare(strict_types=1);

namespace Francken\Association\Committees\Exports;

use Francken\Association\Boards\Board;
use Francken\Association\Committees\Committee;
use Francken\Association\Committees\CommitteeMember;
use Francken\Association\LegacyMember;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Webmozart\Assert\Assert;

class ActiveMembersExport implements FromCollection, WithTitle, WithHeadings, WithMapping
{
    private Board $board;

    public function __construct(Board $board)
    {
        $this->board = $board;
    }

    public function title() : string
    {
        return 'Active members';
    }

    public function headings() : array
    {
        return [
            'Member id',
            'Member',
        ];
    }

    public function collection() : Collection
    {
        return $this->board
            ->hasManyThrough(CommitteeMember::class, Committee::class)
            ->with(['member'])
            ->get()
            ->unique(function (CommitteeMember $member) {
                return $member->member_id;
            });
    }

    public function map($committeeMember) : array
    {
        Assert::isInstanceOf($committeeMember, CommitteeMember::class);
        Assert::isInstanceOf($committeeMember->member, LegacyMember::class);

        return [
            'member_id' => $committeeMember->member_id,
            'member' => $committeeMember->member->fullname,
        ];
    }
}
