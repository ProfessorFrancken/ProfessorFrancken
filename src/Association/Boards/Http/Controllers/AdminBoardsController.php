<?php

declare(strict_types=1);

namespace Francken\Association\Boards\Http\Controllers;

use Francken\Association\Boards\Board;
use Francken\Association\Boards\BoardsRepository;
use Illuminate\Http\Request;

final class AdminBoardsController
{
    public const PHOTO_POSITIONS = [
        '', 'NorthWest', 'North', 'NorthEast', 'West', 'Center', 'East', 'SouthWest', 'South', 'SouthEast'
    ];

    public function index(BoardsRepository $boards)
    {
        return view('admin.association.boards.index', [
            'boards' => $boards->all()
        ]);
    }

    public function create()
    {
        return view('admin.association.boards.create', [
            'board' => new Board(),
            'photo_positions' => self::PHOTO_POSITIONS
        ]);
    }

    public function store(Request $request) : void
    {
        dd($request->all());

        $installed_at = DateTimeImmutable::createFromFormat(
            $request->input('install_date')
        );

        if ($request->hasFile('photo')) {
            $year = (int)$installed_at->format('Y');
            $request->photo->storeAs(
                'images/boards/',
                $year . ($year + 1) . '.' . $photo->extension()
            );
        }

        $board = Board::install(
            $request->input('name', ''),
            $photo,
            self::PHOTO_POSITIONS[$request->get('photo_position')],
            $installed_at,
            collect()
        );

        // Install a board
        // add members to the legacy board models
    }

    public function edit(Board $board)
    {
        return view('admin.association.boards.index', [
            'board' => $board,
            'photo_positions' => self::PHOTO_POSITIONS
        ]);
    }

    public function update(Board $board) : void
    {
    }

    public function remove(Board $board) : void
    {
    }
}
