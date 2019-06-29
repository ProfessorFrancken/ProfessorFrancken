<?php

declare(strict_types=1);

namespace Francken\Association\Boards\Http\Controllers;

use Francken\Association\Boards\Board;

final class BoardsController
{
    public function index()
    {
        return view(
            'association.boards.index',
            [
                'boards' => Board::orderBy('installed_at', 'desc')->get(),
                'breadcrumbs' => [
                    ['url' => '/association/', 'text' => 'Association'],
                    ['url' => action([static::class, 'index']), 'text' => 'Boards'],
                ],
            ]
);
    }
}
