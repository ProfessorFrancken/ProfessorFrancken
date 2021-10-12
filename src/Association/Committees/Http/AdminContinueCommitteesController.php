<?php

declare(strict_types=1);

namespace Francken\Association\Committees\Http;

use Francken\Association\Boards\Board;
use Francken\Association\Committees\Committee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Webmozart\Assert\Assert;

final class AdminContinueCommitteesController
{
    public function store(Request $request, Board $board) : RedirectResponse
    {
        $committeeId = $request->input('committee_id');

        /** @var Committee $committeeToContinue */
        $committeeToContinue = Committee::findOrFail($committeeId);
        Assert::isInstanceOf($committeeToContinue, Committee::class);

        $committee = Committee::continueFrom($committeeToContinue, $board);

        return redirect()->action(
            [AdminCommitteesController::class, 'show'],
            ['board' => $board, 'committee' => $committee]
        );
    }
}
