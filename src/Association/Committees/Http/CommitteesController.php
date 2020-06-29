<?php

declare(strict_types=1);

namespace Francken\Association\Committees\Http;

use Francken\Association\Boards\Board;
use Francken\Association\Committees\Committee;

final class CommitteesController
{
    public function redirect()
    {
        $board = Board::find(request('board_id'));

        if ($board === null) {
            $board = Board::latest()->first();
        }

        return redirect()->action(
            [self::class, 'index'],
            ['boardYear' => $board->board_year->toSlug()]
        );
    }

    public function redirectCommittee(string $committeeLink)
    {
        $board = Board::find(request('board_id'));

        if ($board === null) {
            $board = Board::latest()->first();
        }

        return redirect()->action(
            [self::class, 'show'],
            ['boardYear' => $board->board_year->toSlug(), 'committee' => $committeeLink]
        );
    }

    public function index(string $boardYear)
    {
        $board = $this->boardFromBoardYear($boardYear);

        return view('committees.index')
            ->with([
                'board' => $board,
                'committees' => $board->committees,
                'breadcrumbs' => [
                    ['url' => '/association', 'text' => 'Association'],
                    ['url' => action([static::class, 'index'], ['boardYear' => $board->board_year->toSlug()]), 'text' => $board->board_year->toString()],
                    ['url' => action([static::class, 'index'], ['boardYear' => $board->board_year->toSlug()]), 'text' => 'Committees'],
                ]
            ]);
    }

    public function show(string $boardYear, Committee $committee)
    {
        $board = $this->boardFromBoardYear($boardYear);
        $committee->load(['members.member']);

        return view($committee->page())->with([
            'board' => $board,
            'committee' => $committee,
            'committees' => $board->committees,
            'breadcrumbs' => [
                ['url' => '/association', 'text' => 'Association'],
                ['url' => action([static::class, 'index'], ['boardYear' => $board->board_year->toSlug()]), 'text' => $board->board_year->toString()],
                ['url' => action([static::class, 'index'], ['boardYear' => $board->board_year->toSlug()]), 'text' => 'Committees'],
                ['text' => $committee->name()],
            ]
        ]);
    }

    private function boardFromBoardYear(string $boardYear) : Board
    {
        preg_match("/(\d{4})-(\d{4})/", $boardYear, $matches);

        $startOfBoardYear = $matches[0];
        return Board::whereYear('installed_at', $startOfBoardYear)->firstOrFail();
    }
}
