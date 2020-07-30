<?php


declare(strict_types=1);

namespace Francken\Association\Committees\Exports;

use Francken\Association\Boards\Board;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ActiveMembersListExport implements WithMultipleSheets
{
    private Board $board;

    public function __construct(Board $board)
    {
        $this->board = $board;
    }

    public function sheets() : array
    {
        return [
            'Active members' => new ActiveMembersExport($this->board),
            'Committee members' => new CommitteeMembersExport($this->board)
        ];
    }
}
