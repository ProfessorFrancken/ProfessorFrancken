<?php

declare(strict_types=1);

namespace Francken\Association\Members\Http\Controllers\Admin;

use Francken\Association\Boards\Board;
use Francken\Association\Committees\CommitteeMember;
use Francken\Association\LegacyMember;
use Francken\Association\Members\Http\Requests\AdminSearchMembersRequest;
use Francken\Shared\Clock\Clock;
use Francken\Shared\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;

final class MembersController extends Controller
{
    public function index(AdminSearchMembersRequest $request, Clock $clock) : View
    {
        $currentBoard = Board::current()->firstOrFail();
        $currentCommitteesIds = $currentBoard->committees->pluck('id');

        $currentActiveMemberIds = CommitteeMember::whereIn('committee_id', $currentCommitteesIds)->select('member_id')->distinct()->pluck('member_id');

        $activeMemberIds = CommitteeMember::select('member_id')->distinct()->pluck('member_id');

        $today = $clock->now();
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
            )
            ->orderBy('id', 'desc')
            ->paginate()
            ->appends($request->except('page'));

        $studies = LegacyMember::distinct()
            ->select('studierichting')
            ->get()
            ->mapWithKeys(fn ($study) => [$study->studierichting => $study->studierichting])
            ->prepend("All", null);

        $memberTypes = LegacyMember::distinct()
            ->select('type_lid')
            ->get()
            ->mapWithKeys(fn ($study) => [$study->type_lid => $study->type_lid])
            ->prepend("All", null);

        return view('admin.association.members.index', [
            'studies' => $studies,
            'memberTypes' => $memberTypes,
            'members' => $members,
            'request' => $request,

            'all_members' => $this->searchMemberQuery(LegacyMember::query(), $request)->count(),
            'new_members' => $this->searchMemberQuery(LegacyMember::query(), $request)->where('created_at', '>', $today->modify('-1 year'))->count(),
            'active_members' => $this->searchMemberQuery(LegacyMember::query(), $request)->whereIn('id', $activeMemberIds)->count(),
            'current_active_members' => $this->searchMemberQuery(LegacyMember::query(), $request)->whereIn('id', $currentActiveMemberIds)->count(),
            'alumni_members' => $this->searchMemberQuery(LegacyMember::query(), $request)->count(),
            'cancelled_membership' => $this->searchMemberQuery(LegacyMember::query(), $request)->whereNotNull('einde_lidmaatschap')->count(),

            'breadcrumbs' => [
                ['url' => action([self::class, 'index']), 'text' => 'Members'],
            ]
        ]);
    }

    public function show(LegacyMember $member) : view
    {
        return view('admin.association.members.show', [
            'member' => $member,

            'breadcrumbs' => [
                ['url' => action([self::class, 'index']), 'text' => 'Members'],
                ['url' => action([self::class, 'show'], ['member' => $member]), 'text' => $member->fullname],
            ]
        ]);
    }

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
