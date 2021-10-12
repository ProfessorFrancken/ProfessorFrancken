<?php

declare(strict_types=1);

namespace Francken\Association\Committees\Http;

use Francken\Association\Boards\Board;
use Francken\Association\Committees\Committee;
use Francken\Association\Committees\FileUploader;
use Francken\Association\Committees\Http\Requests\AdminCommitteeRequest;
use Francken\Shared\Markdown\ContentCompiler;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\View\View;

final class AdminCommitteesController
{
    private FileUploader $uploader;

    public function __construct(FileUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function index(Board $board) : View
    {
        $committees = $board->committees()
            ->with(['logoMedia', 'members.member'])
            ->orderBy('name', 'asc')
            ->get();

        $boards = Board::orderBy('installed_at', 'desc')->get();
        $boardYears = $boards->mapWithKeys(fn (Board $board) : array => [$board->id => $board->board_name->toString()]);

        $continuableCommittees = $this->getContinuableCommittees($board);

        return view('admin.association.committees.index')
            ->with([
                'board' => $board,
                'committees' => $committees,
                'continueable_committees' => $continuableCommittees,
                'selected_board' => $board,
                'selected_board_id' => $board->id,
                'board_years' => $boardYears,
                'breadcrumbs' => [
                    ['url' => action([AdminRedirectCommitteesController::class, 'index']), 'text' => 'Committees'],
                    ['url' => action([static::class, 'index'], ['board' => $board]), 'text' => $board->name],
                ]
            ]);
    }

    public function show(Board $board, Committee $committee) : View
    {
        $committee->load(['members.member']);

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

    public function create(Board $board) : View
    {
        $continuableCommittees = $this->getContinuableCommittees($board);
        $parentCommittees = $this->getParentCommittees($continuableCommittees);

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

    public function store(AdminCommitteeRequest $request, Board $board, ContentCompiler $compiler) : RedirectResponse
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

    public function edit(Board $board, Committee $committee) : View
    {
        $continuableCommittees = $this->getContinuableCommittees($board);
        $parentCommittees = $this->getParentCommittees($continuableCommittees);

        $parentCommittee = $committee->parentCommittee;
        if ($parentCommittee && $parentCommittee->board instanceof Board) {
            $parentCommittees->prepend(
                $parentCommittee->name . '(' . $parentCommittee->board->board_name->toString() . ')',
                $parentCommittee->id
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

    public function update(AdminCommitteeRequest $request, Board $board, Committee $committee, ContentCompiler $compiler) : RedirectResponse
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

    public function destroy(Board $board, Committee $committee) : RedirectResponse
    {
        $committee->delete();

        return redirect()->action([self::class, 'index'], ['board' => $board]);
    }

    private function getContinuableCommittees(Board $board): Collection
        {
        return  Committee::query()
            ->with(['board', 'logoMedia'])
            ->whereDoesntHave('childCommittee')
            // HACK here we assume boards are always in order so that we don't select
            // committees from future boards when looking at an older board's committee page
            ->where('board_id', '<', $board->id)
            ->orderBy('board_id', 'desc')
            ->orderBy('name', 'asc')
            ->get();

        }


    private function getParentCommittees(Collection $continuableCommittees): Collection
    {
        return $continuableCommittees->mapWithKeys(
            function ($committee): array {
                /** @var Committee $committee */
                /** @var Board $board */
                $board = $committee->board;

                return [
                    $committee->id => $committee->name . ' (' . $board->board_name->toString() . ')'
                ];
            }
        );
    }
}
