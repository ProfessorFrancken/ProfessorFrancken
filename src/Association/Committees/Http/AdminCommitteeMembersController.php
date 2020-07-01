<?php

declare(strict_types=1);

namespace Francken\Association\Committees\Http;

use Francken\Association\Boards\Board;
use Francken\Association\Committees\Committee;
use Francken\Association\Committees\CommitteeMember;
use Francken\Asssociation\Committees\Http\Requests\AdminCommitteeMemberRequest;

final class AdminCommitteeMembersController
{
    public function store(AdminCommitteeMemberRequest $request, Board $board, Committee $committee)
    {
        $committee->members()->save(
            new CommitteeMember([
                'committee_id' => $committee->id,
                'member_id' => $request->memberId(),
                'function' => $request->function(),
                'installed_at' => $request->installedAt(),
                'decharged_at' => $request->dechargedAt(),
            ])
        );

        return redirect()->action(
            [AdminCommitteesController::class, 'show'],
            ['board' => $board, 'committee' => $committee]
        );
    }

    public function edit(Board $board, Committee $committee, CommitteeMember $member)
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
                    ['url' => action([AdminCommitteesController::class, 'index'], ['board' => $board]), 'text' => $board->name],
                    ['url' => action([AdminCommitteesController::class, 'show'], ['board' => $board, 'committee' => $committee]), 'text' => $committee->name],
                    ['url' => action([static::class, 'edit'], ['board' => $board, 'committee' => $committee]), 'text' => 'Members / Edit'],
                ]
            ]);
    }

    public function update(AdminCommitteeMemberRequest $request, Board $board, Committee $committee, CommitteeMember $member)
    {
        return redirect()->action(
            [AdminCommitteesController::class, 'show'],
            ['board' => $board, 'committee' => $committee]
        );
    }

    public function destroy(Board $board, Committee $committee, CommitteeMember $member)
    {
        $member->delete();

        return redirect()->action(
            [AdminCommitteesController::class, 'show'],
            ['board' => $board, 'committee' => $committee]
        );
    }
}
