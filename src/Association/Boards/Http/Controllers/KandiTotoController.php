<?php

declare(strict_types=1);

namespace Francken\Association\Boards\Http\Controllers;

use Francken\Association\Boards\BoardYear;
use Francken\Association\Boards\Http\Requests\KandiTotoRequest;
use Francken\Association\Boards\KandiToto\Bet;
use Francken\Shared\Clock\Clock;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class KandiTotoController
{
    public function index(Request $request, Clock $clock) : View
    {
        $today = $clock->now();
        $boardYear = BoardYear::fromDate($today);


        $bet = Bet::where('member_id', $request->user()->member_id)
            ->boardYear($boardYear)
            ->first();

        return view('association.boards.kandi-toto.index', [
            'boardYear' => $boardYear,
            'bet' => $bet,
            'breadcrumbs' => [
                ['url' => '/association/', 'text' => 'Association'],
                ['url' => action([BoardsController::class, 'index']), 'text' => 'Boards'],
                ['url' => action([static::class, 'index']), 'text' => 'Kandi toto'],
            ],
        ]);
    }

    public function store(KandiTotoRequest $request, Clock $clock) : RedirectResponse
    {
        $today = $clock->now();

        Bet::submit(
            $request->boardMember(),
            BoardYear::fromDate($today),
            $request->positions()
        );

        return redirect()->action(([static::class, 'index']));
    }
}
