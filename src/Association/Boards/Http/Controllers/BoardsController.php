<?php

declare(strict_types=1);

namespace Francken\Association\Boards\Http\Controllers;

use Francken\Association\Boards\Board;
use Francken\Shared\Clock\Clock;

final class BoardsController
{
    public function index(Clock $clock)
    {
        $boards = Board::orderBy('installed_at', 'desc')
            ->where('installed_at', '<', $clock->now())
            ->get();

        return view(
            'association.boards.index',
            [
                'boards' => $boards,
                'breadcrumbs' => [
                    ['url' => '/association/', 'text' => 'Association'],
                    ['url' => action([static::class, 'index']), 'text' => 'Boards'],
                ],
            ]
);
    }
}
