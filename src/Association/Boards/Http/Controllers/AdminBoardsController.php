<?php

declare(strict_types=1);

namespace Francken\Association\Boards\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use DateTimeImmutable;
use Francken\Association\Boards\Board;
use Francken\Association\Boards\BoardMember;
use Francken\Association\Boards\BoardYear;
use Francken\Association\Boards\Http\Requests\BoardRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Plank\Mediable\Media;
use Plank\Mediable\MediaUploader;

final class AdminBoardsController
{
    public const PHOTO_POSITIONS = [
        '', 'NorthWest', 'North', 'NorthEast', 'West', 'Center', 'East', 'SouthWest', 'South', 'SouthEast'
    ];
    private MediaUploader $uploader;

    public function __construct(MediaUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function index()
    {
        $boards = Board::orderBy('installed_at', 'desc')
            ->withPhotos()
            ->with(['members' => function ($query) {
                return $query->withPhotos();
            }])
            ->get();

        return view('admin.association.boards.index', [
            'boards' => $boards,
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

    public function store(BoardRequest $request): RedirectResponse
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
                function (array $member) use ($request): array {
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

    public function update(BoardRequest $request, Board $board): RedirectResponse
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
        });

        return redirect()->action([self::class, 'index']);
    }

    public function remove(Board $board) : void
    {
    }

    private function uploadPhoto(
        ?UploadedFile $photo,
        BoardYear $board_year,
        string $name
    ) : ?Media {
        if ($photo === null) {
            return null;
        }

        $directory = "images/boards/" . Str::slug($board_year->toString()) . "/";

        return $this->uploader->fromSource($photo)
            ->toDirectory($directory)
            ->useFilename(Str::slug($name))
            ->upload();
    }
}
