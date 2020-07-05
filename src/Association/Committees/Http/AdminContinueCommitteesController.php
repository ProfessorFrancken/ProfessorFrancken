<?php

declare(strict_types=1);

namespace Francken\Association\Committees\Http;

use Francken\Association\Boards\Board;
use Francken\Association\Committees\Committee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class AdminContinueCommitteesController
{
    public function store(Request $request, Board $board) : RedirectResponse
    {
        $committeeId = $request->input('committee_id');

        $committeeToContinue = Committee::findOrFail($committeeId);

        $committee = Committee::continueFrom($committeeToContinue, $board);

        return redirect()->action(
            [AdminCommitteesController::class, 'show'],
            ['board' => $board, 'committee' => $committee]
        );
    }
}
