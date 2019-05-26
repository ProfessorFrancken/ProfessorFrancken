<?php

declare(strict_types=1);

namespace Francken\Association\Boards\Http\Controllers;

use DateTimeImmutable;
use Francken\Association\Boards\Board;
use Francken\Association\Boards\BoardMember;
use Francken\Association\Boards\BoardYear;
use Francken\Association\Boards\Http\Requests\BoardRequest;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

final class AdminBoardsController
{
    public const PHOTO_POSITIONS = [
        '', 'NorthWest', 'North', 'NorthEast', 'West', 'Center', 'East', 'SouthWest', 'South', 'SouthEast'
    ];

    public function index()
    {
        return view('admin.association.boards.index', [
            'boards' => Board::orderBy('installed_at', 'desc')->with('members')->get(),
            'breadcrumbs' => [
                ['url' => action([static::class, 'index']), 'text' => 'Boards'],
            ]
        ]);
    }

    public function create()
    {
        return view('admin.association.boards.create', [
            'board' => new Board(),
            'photo_positions' => self::PHOTO_POSITIONS,
            'breadcrumbs' => [
                ['url' => action([static::class, 'index']), 'text' => 'Boards'],
                ['url' => action([static::class, 'create']), 'text' => 'Install a board'],
            ]
        ]);
    }

    public function store(BoardRequest $request)
    {
        $board_photo = $this->uploadPhoto(
            $request->photo,
            $request->boardYear(),
            $request->boardName()->toString()
        );
        $photo_position = self::PHOTO_POSITIONS[$request->get('photo_position')];

        $board = Board::install(
            $request->boardName(),
            $board_photo,
            $photo_position,
            $request->installedAt(),
            $request->members()->map(
                function (array $member) use ($request) {
                    $photo = $this->uploadPhoto(
                        $member['photo'] ?? null,
                        $request->boardYear(),
                        $member['title']
                    );

                    return [
                        'member_id' => (int)$member['member_id'],
                        'title' => $member['title'],
                        'photo' => $photo
                    ];
                }
            )
        );

        return redirect()->action([self::class, 'index']);
    }

    public function edit(Board $board)
    {
        return view('admin.association.boards.edit', [
            'board' => $board,
            'photo_positions' => self::PHOTO_POSITIONS,
            'breadcrumbs' => [
                ['url' => action([static::class, 'index']), 'text' => 'Boards'],
                // ['url' => action([static::class, 'show'], $board->id), 'text' => $board->name],
                ['url' => action([static::class, 'edit'], $board->id), 'text' => $board->name . ' / Edit'],
            ]
        ]);
    }

    public function update(BoardRequest $request, Board $board)
    {
        $photo = $this->uploadPhoto(
            $request->photo,
            $request->boardYear(),
            $request->boardName()->toString()
        );

        $board->updateBoardAttributes(
            $request->boardName(),
            self::PHOTO_POSITIONS[$request->get('photo_position')],
            $request->installedAt(),
            $request->demissionedAt(),
            $request->dechargedAt(),
            $photo
        );

        $request->members()->each(function (array $member_data) use ($board) : void {
            $member = $board->members()->where('id', $member_data['id'])->first();

            $photo = $this->uploadPhoto(
                $member_data['photo'] ?? null,
                $board->board_year,
                $member_data['title']
            );

            // install new member
            if ($member === null) {
                // If no install date was given, default to the install date of the board
                $installed_at = $member_data['installed_at'] ?? DateTimeImmutable::createFromMutable(
                    $board->installed_at
                );

                BoardMember::install(
                    $board,
                    (int)$member_data['member_id'],
                    $member_data['title'],
                    $installed_at,
                    $photo
                );
            } else {
                $member->updateBoardMemberAttributes(
                    (int)$member_data['member_id'],
                    $member_data['title'],
                    $member_data['installed_at'],
                    $member_data['demissioned_at'],
                    $member_data['decharged_at'],
                    $photo
                );
            }

            // $member->updateMemberAttributes(
                // );
        });

        // $request->members->
        // call method on board member instead...
        // member should be able to determine if its state changed and dispatch an event
        // accordingaly
        // $board->members->each(function (BoardMember $member) use ($request) : void {
        // });

        return redirect()->action([self::class, 'index']);
    }

    public function remove(Board $board) : void
    {
    }

    private function updateBoard(Board $board, Request $request) : void
    {
        $photo_position = self::PHOTO_POSITIONS[$request->get('photo_position')];

        $installed_at = DateTimeImmutable::createFromFormat(
            'Y-m-d',
            $request->input('installed_at')
        );
        $board_year = BoardYear::fromInstallDate($installed_at);

        $name = $request->input('name', $board_year->toString());
        $photo = $this->uploadPhoto($request->photo, $board_year, $name);

        $attributes = array_merge(
            ['photo_position' => $photo_position],
            $request->only(['name', 'installed_at', 'demissioned_at', 'decharged_at'])
        );
        $attributes['photo'] = $photo;

        $board->update($attributes);
    }

    private function uploadPhoto(
        ?UploadedFile $photo,
        BoardYear $board_year,
        string $name
    ) : ?string {
        if ($photo === null) {
            return null;
        }

        $directory = "images/boards/{$board_year->toString()}/";
        $photo_name = str_slug($name) . '.' . $photo->extension();

        return asset(
            $photo->storePubliclyAs($directory, $photo_name, ['disk' => 'public'])
        );
    }
}
