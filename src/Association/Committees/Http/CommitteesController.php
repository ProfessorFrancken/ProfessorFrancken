<?php

declare(strict_types=1);

namespace Francken\Association\Committees\Http;

use Francken\Association\Boards\Board;
use Francken\Association\Committees\Committee;
use Francken\Auth\Http\Controllers\LoginController;
use Francken\Shared\Clock\Clock;
use Illuminate\Http\Request;

final class CommitteesController
{
    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index(Request $request, Clock $clock, Board $board)
    {
        if (! $request->user() && $clock->now()->modify('-5 years') > $board->installed_at) {
            return redirect()->action([
               LoginController::class, 'showLoginForm'
            ]);
        }

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

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show(Request $request, Clock $clock, Board $board, Committee $committee)
    {
        if (! $request->user() && $clock->now()->modify('-5 years') > $board->installed_at) {
            return redirect()->action([
               LoginController::class, 'showLoginForm'
            ]);
        }

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
