<?php

declare(strict_types=1);

namespace Francken\Association\Committees\Http;

use Francken\Association\Boards\Board;
use Francken\Association\Committees\HardcodedCommitteesRepository;

final class CommitteesController
{
    private $committees;

    public function __construct(HardcodedCommitteesRepository $repo)
    {
        $this->committees = $repo;
    }

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
        $committees = $this->committees->list();

        return view('committees.index')
            ->with('committees', $committees)
            ->with('breadcrumbs', [
                ['url' => '/association', 'text' => 'Association'],
                ['url' => action([static::class, 'index'], ['boardYear' => $board->board_year->toSlug()]), 'text' => $board->board_year->toString()],
                ['url' => action([static::class, 'index'], ['boardYear' => $board->board_year->toSlug()]), 'text' => 'Committees'],
            ]);
    }

    public function show(string $boardYear, string $committee)
    {
        $link = $committee;
        $board = $this->boardFromBoardYear($boardYear);
        $committees = $this->committees->list();
        $committee = $this->committees->findByLink($link);

        $view = view($committee->page());

        return $view->with('committee', $committee)
            ->with('committees', $committees)
            ->with('breadcrumbs', [
                ['url' => '/association', 'text' => 'Association'],
                ['url' => action([static::class, 'index'], ['boardYear' => $board->board_year->toSlug()]), 'text' => $board->board_year->toString()],
                ['url' => action([static::class, 'index'], ['boardYear' => $board->board_year->toSlug()]), 'text' => 'Committees'],
                ['text' => $committee->name()],
            ]);
    }

    private function boardFromBoardYear(string $boardYear) : Board
    {
        preg_match("/(\d{4})-(\d{4})/", $boardYear, $matches);
        $startOfBoardYear = (int)$matches[0];
        return Board::whereYear('installed_at', $startOfBoardYear)->firstOrFail();
    }
}
