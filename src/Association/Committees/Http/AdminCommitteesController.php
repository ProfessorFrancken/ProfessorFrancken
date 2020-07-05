<?php

declare(strict_types=1);

namespace Francken\Association\Committees\Http;

use Francken\Association\Boards\Board;
use Francken\Association\Committees\Committee;
use Francken\Association\Committees\FileUploader;
use Francken\Association\Committees\Http\Requests\AdminCommitteeRequest;
use Francken\Association\LegacyMember;
use Francken\Shared\Markdown\ContentCompiler;

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
        $committees = $board->committees()
            ->with(['logoMedia', 'members.member'])
            ->orderBy('name', 'asc')
            ->get();

        $boards = Board::orderBy('installed_at', 'desc')->get();
        $board_years = $boards->mapWithKeys(function (Board $board) {
            return [$board->id => $board->board_name->toString()];
        });

        $continuableCommittees =  Committee::query()
            ->with(['board', 'logoMedia'])
            ->whereDoesntHave('childCommittee')
            // HACK here we assume boards are always in order so that we don't select
            // committees from future boards when looking at an older board's committee page
            ->where('board_id', '<', $board->id)
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
        $committee->load(['members.member']);

        return view('admin.association.committees.show')
            ->with([
                'members' => LegacyMember::autocomplete(),
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
        $continuableCommittees =  Committee::query()
            ->with(['board', 'logoMedia'])
            ->whereDoesntHave('childCommittee')
            // HACK here we assume boards are always in order so that we don't select
            // committees from future boards when looking at an older board's committee page
            ->where('board_id', '<', $board->id)
            ->orderBy('board_id', 'desc')
            ->orderBy('name', 'asc')
            ->get();

        $parentCommittees = $continuableCommittees->mapWithKeys(
            function ($c) {
                return [
                    $c->id => $c->name . ' (' . $c->board->board_name->toString() . ')'
                ];
            }
        );

        return view('admin.association.committees.create')
            ->with([
                'board' => $board,
                'committee' => new Committee(),
                'continueable_committees' => $continuableCommittees,
                'parent_committees' => $parentCommittees,
                'breadcrumbs' => [
                    ['url' => action([AdminRedirectCommitteesController::class, 'index']), 'text' => 'Committees'],
                    ['url' => action([static::class, 'index'], ['board' => $board]), 'text' => $board->name],
                    ['url' => action([static::class, 'create'], ['board' => $board]), 'text' => 'Add committee'],
                ]
            ]);
    }

    public function store(AdminCommitteeRequest $request, Board $board, ContentCompiler $compiler)
    {
        $markdown = $compiler->content($request->content());
        $committee = Committee::create([
            'board_id' => $board->id,
            'parent_committee_id' => $request->parentCommitteeId(),
            'name' => $request->name(),
            'slug' => $request->slug(),
            'goal' => $request->goal(),
            'email' => $request->email(),

            'source_content' => $markdown->originalMarkdown(),
            'compiled_content' => $markdown->compiledContent(),

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
        $continuableCommittees =  Committee::query()
            ->with(['board', 'logoMedia'])
            ->whereDoesntHave('childCommittee')
            // HACK here we assume boards are always in order so that we don't select
            // committees from future boards when looking at an older board's committee page
            ->where('board_id', '<', $board->id)
            ->orderBy('board_id', 'desc')
            ->orderBy('name', 'asc')
            ->get();

        $parentCommittees = $continuableCommittees->mapWithKeys(
            function ($c) {
                return [
                    $c->id => $c->name . ' (' . $c->board->board_name->toString() . ')'
                ];
            }
        );

        $parent_committee = $committee->parentCommittee;
        if ($parent_committee) {
            $parentCommittees->prepend(
                $parent_committee->name . '(' . $parent_committee->board->board_name->toString() . ')',
                $parent_committee->id
            );
        }


        return view('admin.association.committees.edit')
            ->with([
                'board' => $board,
                'committee' => $committee,
                'parent_committees' => $parentCommittees,
                'breadcrumbs' => [
                    ['url' => action([AdminRedirectCommitteesController::class, 'index']), 'text' => 'Committees'],
                    ['url' => action([static::class, 'index'], ['board' => $board]), 'text' => $board->name],
                    ['url' => action([static::class, 'show'], ['board' => $board, 'committee' => $committee]), 'text' => $committee->name],
                    ['url' => action([static::class, 'edit'], ['board' => $board, 'committee' => $committee]), 'text' => 'Edit'],
                ]
            ]);
    }

    public function update(AdminCommitteeRequest $request, Board $board, Committee $committee, ContentCompiler $compiler)
    {
        $markdown = $compiler->content($request->content());

        $committee->update([
            'parent_committee_id' => $request->parentCommitteeId(),
            'name' => $request->name(),
            'slug' => $request->slug(),
            'goal' => $request->goal(),
            'email' => $request->email(),

            'source_content' => $markdown->originalMarkdown(),
            'compiled_content' => $markdown->compiledContent(),

            'is_public' => $request->isPublic(),
        ]);

        $this->uploader->uploadLogo($request->logo, $committee);
        $this->uploader->uploadPhoto($request->photo, $committee);

        return redirect()->action(
            [self::class, 'show'],
            ['board' => $board, 'committee' => $committee]
        );
    }

    public function destroy(Board $board, Committee $committee)
    {
        $committee->delete();

        return redirect()->action([self::class, 'index'], ['board' => $board]);
    }
}
