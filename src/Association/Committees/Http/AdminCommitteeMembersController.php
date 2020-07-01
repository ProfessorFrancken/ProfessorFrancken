<?php

declare(strict_types=1);

namespace Francken\Association\Committees\Http;

use DB;
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
        return view('admin.association.committees.members.edit')
            ->with([
                'board' => $board,
                'committee' => $committee,
                'member' => $member,
                'members' => $this->members(),
                'breadcrumbs' => [
                    ['url' => action([AdminRedirectCommitteesController::class, 'index']), 'text' => 'Committees'],
                    ['url' => action([AdminCommitteesController::class, 'index'], ['board' => $board]), 'text' => $board->name],
                    ['url' => action([AdminCommitteesController::class, 'show'], ['board' => $board, 'committee' => $committee]), 'text' => $committee->name],
                    ['url' => action([static::class, 'edit'], ['board' => $board, 'committee' => $committee, 'member' => $member]), 'text' => 'Members / Edit'],
                ]
            ]);
    }

    public function update(AdminCommitteeMemberRequest $request, Board $board, Committee $committee, CommitteeMember $member)
    {
        $member->update([
                'function' => $request->function(),
                'installed_at' => $request->installedAt(),
                'decharged_at' => $request->dechargedAt(),
        ]);

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

    private function members()
    {
        return DB::connection('francken-legacy')
            ->table('leden')
            ->where('is_lid', true)
            ->select(['id',  'voornaam', 'tussenvoegsel', 'achternaam'])
            ->orderBy('id', 'desc')
            ->get();
    }
}
