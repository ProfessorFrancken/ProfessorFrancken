<?php

declare(strict_types=1);

namespace Francken\Association\Committees\Http;

use Francken\Association\Boards\Board;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class AdminRedirectCommitteesController
{
    public function index(Request $request) : RedirectResponse
    {
        $board = Board::find($request->input('board_id'));

        if ($board === null) {
            $board = Board::current()->first();
        }

        return redirect()->action(
            [AdminCommitteesController::class, 'index'],
            ['board' => $board]
        );
    }
}
