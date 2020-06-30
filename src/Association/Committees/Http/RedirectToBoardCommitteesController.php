<?php

declare(strict_types=1);

namespace Francken\Association\Committees\Http;

use Francken\Association\Boards\Board;
use Francken\Shared\Clock\Clock;

final class RedirectToBoardCommitteesController
{
    public function index(Clock $clock)
    {
        $board = Board::where('installed_at', '<', $clock->now())
               ->find(request('board_id'));

        if ($board === null) {
            $board = Board::where('installed_at', '<', $clock->now())
                   ->latest()
                   ->first();
        }

        return redirect()->action(
            [CommitteesController::class, 'index'],
            ['board' => $board]
        );
    }

    public function show(Clock $clock, string $committeeLink)
    {
        $board = Board::where('installed_at', '<', $clock->now())
               ->find(request('board_id'));

        if ($board === null) {
            $board = Board::where('installed_at', '<', $clock->now())
                   ->latest()
                   ->first();
        }

        return redirect()->action(
            [CommitteesController::class, 'show'],
            ['board' => $board, 'committee' => $committeeLink]
        );
    }
}
