<?php

declare(strict_types=1);

namespace Francken\Association\Committees\Http;

use Francken\Association\Boards\Board;
use Francken\Association\Committees\Committee;
use Francken\Association\Committees\FileUploader;
use Francken\Asssociation\Committees\Http\Requests\AdminCommitteeRequest;

final class AdminCommitteesController
{
    /** @var FileUploader */
    private $uploader;

    public function __construct(FileUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function index(Board $board)
    {
        $committees = $board->committees;
        $committees->load(['logoMedia', 'members.member']);

        $boards = Board::orderBy('installed_at', 'desc')->get();
        $board_years = $boards->mapWithKeys(function (Board $board) {
            return [$board->id => $board->board_name->toString()];
        });

        $continuableCommittees =  Committee::query()
            ->with(['board', 'logoMedia'])
            ->whereDoesntHave('childCommittee')
            ->orderBy('board_id', 'desc')
            ->orderBy('name', 'asc')
            ->get();

        return view('admin.association.committees.index')
            ->with([
                'board' => $board,
                'committees' => $committees,
                'continueable_committees' => $continuableCommittees,
                'selected_board' => $board,
                'selected_board_id' => $board->id,
                'board_years' => $board_years,
                'breadcrumbs' => [
                    ['url' => action([AdminRedirectCommitteesController::class, 'index']), 'text' => 'Committees'],
                    ['url' => action([static::class, 'index'], ['board' => $board]), 'text' => $board->name],
                ]
            ]);
    }

    public function show(Board $board, Committee $committee)
    {
        return view('admin.association.committees.show')
            ->with([
                'committee' => $committee,
                'breadcrumbs' => [
                    ['url' => action([AdminRedirectCommitteesController::class, 'index']), 'text' => 'Committees'],
                    ['url' => action([static::class, 'index'], ['board' => $board]), 'text' => $board->name],
                    ['url' => action([static::class, 'show'], ['board' => $board, 'committee' => $committee]), 'text' => $committee->name],
                ]
            ]);
    }

    public function create(Board $board)
    {
        return view('admin.association.committees.create')
            ->with([
                'board' => $board,
                'breadcrumbs' => [
                    ['url' => action([AdminRedirectCommitteesController::class, 'index']), 'text' => 'Committees'],
                    ['url' => action([static::class, 'index'], ['board' => $board]), 'text' => $board->name],
                    ['url' => action([static::class, 'create']), 'text' => 'Add committee'],
                ]
            ]);
    }

    public function store(AdminCommitteeRequest $request, Board $board)
    {
        $committee = Committee::create([
            'board_id' => $request->boardId(),
            'parent_committee_id' => $request->parentCommitteeId(),
            'name' => $request->name(),
            'slug' => $request->slug(),
            'email' => $request->email(),

            // TODO markdown content
            'contents' => $request->contents(),

            'is_public' => $request->isPublic(),
        ]);

        $this->uploader->uploadLogo($request->logo, $committee);
        $this->uploader->uploadPhoto($request->photo, $committee);

        return redirect()->action(
            [self::class, 'show'],
            ['board' => $board, 'committee' => $committee]
        );
    }

    public function edit(Board $board, Committee $committee)
    {
        return view('admin.association.committees.edit')
            ->with([
                'board' => $board,
                'committee' => $committee,
                'breadcrumbs' => [
                    ['url' => action([AdminRedirectCommitteesController::class, 'index']), 'text' => 'Committees'],
                    ['url' => action([static::class, 'index'], ['board' => $board]), 'text' => $board->name],
                    ['url' => action([static::class, 'show'], ['board' => $board, 'committee' => $committee]), 'text' => $committee->name],
                ]
            ]);
    }

    public function update(AdminCommitteeRequest $request, Board $board, Committee $committee)
    {
        $committee->update([
        ]);

        $this->uploader->uploadLogo($request->logo, $committee);
        $this->uploader->uploadPhoto($request->photo, $committee);

        return redirect()->action(
            [self::class, 'show'],
            ['board' => $board, 'committee' => $committee]
        );
    }
}
