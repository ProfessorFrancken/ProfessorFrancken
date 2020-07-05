<?php

declare(strict_types=1);

namespace Francken\Association\Committees\Http;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Francken\Association\Boards\Board;

final class AdminRedirectCommitteesController
{
    public function index(Request $request): RedirectResponse
    {
        $board = Board::find($request->input('board_id'));

        if ($board === null) {
            $board = Board::latest()->first();
        }

        return redirect()->action(
            [AdminCommitteesController::class, 'index'],
            ['board' => $board]
        );
    }
}
