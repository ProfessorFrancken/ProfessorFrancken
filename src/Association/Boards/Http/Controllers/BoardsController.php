<?php

declare(strict_types=1);

namespace Francken\Association\Boards\Http\Controllers;

final class BoardsController
{
    public function index(\Francken\Domain\Boards\BoardRepository $boards)
    {
        return view(
            'association.boards.index',
            [
                'boards' => $boards->all(),
                'breadcrumbs' => [
                    ['url' => '/association/', 'text' => 'Association'],
                    ['url' => action([static::class, 'index']), 'text' => 'Boards'],
                ],
            ]
);
    }
}
