<?php

declare(strict_types=1);

namespace Francken\Association\Committees\Http;

use Francken\Association\Boards\Board;
use Francken\Association\Committees\Exports\ActiveMembersListExport;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

final class AdminActiveMembersExportController
{
    public function index(Board $board) : BinaryFileResponse
    {
        $committees = $board->committees()
            ->with(['logoMedia', 'members.member'])
            ->orderBy('name', 'asc')
            ->get();

        return Excel::download(
            new ActiveMembersListExport($board),
            'active-members.xlsx'
        );
    }
}
