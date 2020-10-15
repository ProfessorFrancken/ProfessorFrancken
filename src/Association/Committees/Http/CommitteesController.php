<?php

declare(strict_types=1);

namespace Francken\Association\Committees\Http;

use Francken\Association\Boards\Board;
use Francken\Association\Committees\Committee;
use Illuminate\View\View;

final class CommitteesController
{
    public function index(Board $board) : View
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

    public function show(Board $board, Committee $committee) : View
    {
        $committees = $board->committees()
            ->where('is_public', true)
            ->with(['board', 'logoMedia'])
            ->orderBy('name', 'asc')
            ->get();

        $committee->load(['members.member']);

        $viewName = $this->committeePage($committee);
        $view = view($viewName);

        return $view->with([
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

    private function committeePage(Committee $committee) : string
    {
        if (($committee->compiled_content ?? '') !== '') {
            return 'committees.content';
        }

        return view()->exists($committee->page)
            ? $committee->page
            : 'committees.show';
    }
}
