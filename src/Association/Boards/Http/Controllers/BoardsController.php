<?php

declare(strict_types=1);

namespace Francken\Association\Boards\Http\Controllers;

use Francken\Association\Boards\Board;
use Francken\Shared\Clock\Clock;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class BoardsController
{
    public function index(Request $request, Clock $clock) : View
    {
        $boards = Board::with(['photoMedia', 'members', 'members.photoMedia'])
            ->orderBy('installed_at', 'desc')
            ->where('installed_at', '<', $clock->now())
            ->when(
                ! $request->user(),
                fn ($query) => $query->where('installed_at', '>=', $clock->now()->modify('-5 years'))
            )
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
