<?php

declare(strict_types=1);

namespace Francken\Association\Committees\Http;

use Francken\Association\Boards\Board;
use Francken\Association\Committees\Committee;

final class AdminCommitteesController
{
    public function index()
    {
        $selectedBoard = Board::find(request('board_id'));
        $boards = Board::orderBy('installed_at', 'desc')->get();
        $committees = Committee::orderBy('naam', 'asc')
            ->with([
                'members' => function ($query) use ($selectedBoard) : void {
                    $query->when($selectedBoard, function ($query, $board) : void {
                        $year = (int) $board->board_year->start()->format('Y');
                        $query->where('jaar', $year);
                    });

                    $query->with('member');
                },
            ])->get()->filter(function (Committee $committee) {
                return $committee->members->isNotEmpty();
            });

        $board_years = $boards->mapWithKeys(function (Board $board) {
            return [$board->id => $board->board_name->toString()];
        });

        return view('admin.association.committees.index')
            ->with([
                'committees' => $committees,
                'selected_board' => $selectedBoard,
                'selected_board_id' => request('board_id'),
                'board_years' => $board_years,
                'breadcrumbs' => [
                    ['url' => action([static::class, 'index']), 'text' => 'Committees'],
                ]
            ]);
    }

    public function show(Committee $committee)
    {
        return view('admin.association.committees.show')
            ->with([
                'committee' => $committee,
                'breadcrumbs' => [
                    ['url' => action([static::class, 'index']), 'text' => 'Committees'],
                    ['url' => action([static::class, 'show'], ['committee' => $committee]), 'text' => $committee->name],
                ]
            ]);
    }

    public function create()
    {
        return view('admin.association.committees.create')
            ->with([
                'breadcrumbs' => [
                    ['url' => action([static::class, 'index']), 'text' => 'Committees'],
                    ['url' => action([static::class, 'create']), 'text' => 'Add committee'],
                ]
            ]);
    }
}
