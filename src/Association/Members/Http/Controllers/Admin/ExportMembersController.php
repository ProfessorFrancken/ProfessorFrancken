<?php

declare(strict_types=1);

namespace Francken\Association\Members\Http\Controllers\Admin;

use Francken\Association\Boards\Board;
use Francken\Association\Committees\CommitteeMember;
use Francken\Association\LegacyMember;
use Francken\Association\Members\Exports\MembersExport;
use Francken\Association\Members\Http\Requests\AdminSearchMembersRequest;
use Francken\Shared\Clock\Clock;
use Francken\Shared\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

final class ExportMembersController extends Controller
{
    public function index(AdminSearchMembersRequest $request, Clock $clock) : BinaryFileResponse
    {
        $today = $clock->now();

        $currentBoard = Board::current()->firstOrFail();
        $currentCommitteesIds = $currentBoard->committees->pluck('id');

        $currentActiveMemberIds = CommitteeMember::whereIn('committee_id', $currentCommitteesIds)->select('member_id')->distinct()->pluck('member_id');

        $activeMemberIds = CommitteeMember::select('member_id')->distinct()->pluck('member_id');

        /** @var Builder<LegacyMember> $members */
        $members = $this->searchMemberQuery(LegacyMember::query(), $request)
            ->when(
                $request->selected('new'),
                fn (Builder $query) : Builder => $query->where('created_at', '>', $today->modify('-1 year'))
            )
            ->when(
                $request->selected('current-active-members'),
                fn (Builder $query) : Builder => $query->whereIn('id', $currentActiveMemberIds)
            )
            ->when(
                $request->selected('active-members'),
                fn (Builder $query) : Builder => $query->whereIn('id', $activeMemberIds)
            )
            ->when(
                $request->selected('alumni'),
                fn (Builder $query) : Builder => $query
            )
            ->when(
                $request->selected('cancelled-membership'),
                fn (Builder $query) : Builder => $query->whereNotNull('einde_lidmaatschap')
            );

        return Excel::download(
            new MembersExport($members),
            sprintf('members_%s.xlsx', $today->format('Y-m-d'))
        );
    }

    /**
     * @param Builder<LegacyMember> $query
     * @return Builder<LegacyMember>
     */
    private function searchMemberQuery(Builder $query, AdminSearchMembersRequest $request) : Builder
    {
        return $query->when(
            $request->firstname(),
            fn (Builder $query, string $firstname) : Builder => $query->where('voornaam', 'like', "%" . $firstname . '%')
        )->when(
            $request->surname(),
            fn (Builder $query, string $surname) : Builder => $query->where('achternaam', 'like', "%" . $surname . '%')
        )->when(
            $request->email(),
            fn (Builder $query, string $email) : Builder => $query->where('emailadres', 'like', "%" . $email . '%')
        )->when(
            $request->study(),
            fn (Builder $query, string $study) : Builder => $query->where('studierichting', 'like', "%" . $study . '%')
        )->when(
            $request->type(),
            fn (Builder $query, string $memberType) : Builder => $query->where('type_lid', 'like', "%" . $memberType . '%')
        );
    }
}
