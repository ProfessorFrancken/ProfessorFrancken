<?php

declare(strict_types=1);

namespace Francken\Association\Committees\Http;

use Francken\Association\Boards\Board;

final class AdminRedirectCommitteesController
{
    public function index()
    {
        $board = Board::find(request('board_id'));

        if ($board === null) {
            $board = Board::latest()->first();
        }

        return redirect()->action(
            [AdminCommitteesController::class, 'index'],
            ['board' => $board]
        );
    }
}
