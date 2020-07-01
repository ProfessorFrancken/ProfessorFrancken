<?php

declare(strict_types=1);

namespace Francken\Association\Committees\Http;

use Francken\Association\Boards\Board;
use Francken\Association\Committees\Committee;

final class CommitteesController
{
    public function index(Board $board)
    {
        $committees = $board->committees()
            ->where('is_public', true)
            ->with(['board', 'logoMedia'])
            ->orderBy('name', 'asc')->get();

        return view('committees.index')
            ->with([
                'board' => $board,
                'committees' => $committees,
                'breadcrumbs' => [
                    ['url' => '/association', 'text' => 'Association'],
                    ['url' => action([static::class, 'index'], ['board' => $board]), 'text' => $board->board_year->toString()],
                    ['url' => action([static::class, 'index'], ['board' => $board]), 'text' => 'Committees'],
                ]
            ]);
    }

    public function show(Board $board, Committee $committee)
    {
        $committees = $board->committees()
            ->where('is_public', true)
            ->with(['board', 'logoMedia'])
            ->orderBy('name', 'asc')
            ->get();

        $committee->load(['members.member']);

        return view($committee->page)
            ->with([
                'board' => $board,
                'committee' => $committee,
                'committees' => $committees,
                'breadcrumbs' => [
                    ['url' => '/association', 'text' => 'Association'],
                    ['url' => action([static::class, 'index'], ['board' => $board]), 'text' => $board->board_year->toString()],
                    ['url' => action([static::class, 'index'], ['board' => $board]), 'text' => 'Committees'],
                    ['text' => $committee->name],
                ]
            ]);
    }
}
