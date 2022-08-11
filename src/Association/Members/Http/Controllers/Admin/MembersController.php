<?php

declare(strict_types=1);

namespace Francken\Association\Members\Http\Controllers\Admin;

use Francken\Association\Boards\Board;
use Francken\Association\Boards\BoardMember;
use Francken\Association\Committees\Committee;
use Francken\Association\Committees\CommitteeMember;
use Francken\Association\LegacyMember;
use Francken\Association\Members\Gender;
use Francken\Association\Members\Http\Requests\AdminMemberRequest;
use Francken\Association\Members\Http\Requests\AdminSearchMembersRequest;
use Francken\Auth\Account;
use Francken\Extern\Alumnus;
use Francken\Shared\Clock\Clock;
use Francken\Shared\Http\Controllers\Controller;
use Francken\Study\BooksSale\Book;
use Francken\Treasurer\MemberExtra;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Webmozart\Assert\Assert;

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
            ->mapWithKeys(function ($study) {
                /** @var LegacyMember $study */
                return [$study->studierichting => $study->studierichting];
            })
            ->prepend("All", null);

        $memberTypes = LegacyMember::distinct()
            ->select('type_lid')
            ->get()
            ->mapWithKeys(function ($study) {
                /** @var LegacyMember $study */
                return [$study->type_lid => $study->type_lid];
            })
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

    public function show(LegacyMember $member, Clock $clock) : view
    {
        $currentBoard = Board::current()->firstOrFail();
        $boardMembers = BoardMember::where('member_id', $member->id)->with(['board'])->get();
        $committeeMembers = CommitteeMember::where('member_id', $member->id)->with(['committee.board'])->get();

        $books = Book::query()->where('buyer_id', $member->id)->orWhere('seller_id', $member->id)->get();
        $alumni = Alumnus::where('member_id', $member->id)->with(['partner'])->get();
        $account = Account::ofMember($member->id)->withCount(['roles', 'permissions'])->first();

        $currentCommittees = $committeeMembers->filter(
            fn (CommitteeMember $member) => $member->committee !== null && $member->committee->board_id === $currentBoard->id
        )->map(
            function (CommitteeMember $member) : Committee {
                Assert::notNull($member->committee);

                return $member->committee;
            }
        );

        $committeesByBoard = $committeeMembers->groupBy(
            function (CommitteeMember $member) {
                Assert::notNull($member->committee);

                return $member->committee->board_id;
            }
        )->values()->sortByDesc(function ($committeeMembers) {
            $aCommittee = $committeeMembers->first()->committee;
            Assert::notNull($aCommittee);

            $board = $aCommittee->board;

            Assert::notNull($board);

            return $board->installed_at;
        });

        $subscription = $member->franckenVrijSubscription;
        $today = $clock->now();
        $consumptionCounterExtra = MemberExtra::ofMember($member->id)->first();


        return view('admin.association.members.show.index', [
            'member' => $member,
            'boardMembers' => $boardMembers,
            'committeeMembers' => $committeeMembers,
            'committeesByBoard' => $committeesByBoard,
            'currentCommittees' => $currentCommittees,
            'account' => $account,
            'alumni' => $alumni,
            'subscription' => $subscription,
            'books' => $books,
            'today' => $today,
            'consumptionCounterExtra' => $consumptionCounterExtra,

            'breadcrumbs' => [
                ['url' => action([self::class, 'index']), 'text' => 'Members'],
                ['url' => action([self::class, 'show'], ['member' => $member]), 'text' => $member->fullname],
            ]
        ]);
    }

    public function edit(LegacyMember $member) : view
    {
        $memberTypeOptions = AdminMemberRequest::MEMBER_TYPE_OPTIONS;
        $consumptionCounterOptions = AdminMemberRequest::CONSUMPTION_COUNTER_OPTIONS;

        return view('admin.association.members.edit', [
            'member' => $member,
            'memberTypeOptions' => $memberTypeOptions,
            'consumptionCounterOptions' => $consumptionCounterOptions,

            'breadcrumbs' => [
                ['url' => action([self::class, 'index']), 'text' => 'Members'],
                ['url' => action([self::class, 'show'], ['member' => $member]), 'text' => $member->fullname],
                ['url' => action([self::class, 'edit'], ['member' => $member]), 'text' => 'Edit'],
            ]
        ]);
    }

    public function update(AdminMemberRequest $request, LegacyMember $member) : RedirectResponse
    {
        $gender = $request->gender()->toString();
        $geslacht = $gender === Gender::MALE
                  ? 'M'
                  : ($gender === Gender::FEMALE
                  ? 'V'
                  : $gender);

        $email = $request->email()->toString();
        $member->update([
            "titel" => $request->title(),
            "initialen" => $request->initials(),
            "voornaam" => $request->firstname(),
            "tussenvoegsel" => $request->insertion(),
            "achternaam" => $request->surname(),
            "geboortedatum" => $request->birthDate()->format('Y-m-d'),
            "nederlands" => $request->knowsDutch(),
            'geslacht' => $geslacht,
            "adres" => $request->address(),
            "postcode" => $request->postalCode(),
            "plaats" => $request->city(),
            "land" => $request->country(),
            "is_nederland" => $request->hasDutchNationality(),
            "emailadres" => $request->email()->toString(),
            "telefoonnummer_mobiel" => $request->phoneNumber(),
            "rekeningnummer"  => $request->iban(),
            "plaats_bank" => $request->bankLocation(),
            "machtiging" => $request->hasAuthorizedDebit(),
            "wanbetaler" => $request->isDefaulter(),
            "gratis_lidmaatschap" => $request->hasFreeMembership(),
            "start_lidmaatschap" => $request->startMembershipDate(),
            "einde_lidmaatschap" => $request->endMembershipDate(),
            "is_lid" => $request->isMember(),
            "type_lid" => $request->memberType(),
            "studentnummer" => $request->studentNumber(),
            "studierichting" => $request->study(),
            "jaar_van_inschrijving" => $request->yearOfRegistration(),
            "afstudeerplek" => $request->placeOfGraduation(),
            "afgestudeerd" => $request->isGraduated(),
            "werkgever" => $request->empoloyer(),
            "nnvnummer" => $request->nnvNumber(),
            "streeplijst" => $request->consumptionCounterPaymentMethod(),
            "mailinglist_email" => $request->mailingListEmail(),
            "mailinglist_post" => $request->mailingListPost(),
            "mailinglist_sms" => $request->mailingListSMS(),
            "mailinglist_constitutiekaart" => $request->mailingListConstitutionalCard(),
            "mailinglist_franckenvrij" => $request->mailingListFranckenVrij(),
            "erelid" => $request->isMemberOfHonors(),
            "notities" => $request->notes(),
        ]);

        $account = Account::ofMember($member->id)->first();

        if ($account && $account->email !== $email) {
            $account->update(['email' => $email]);
        }

        return redirect()->action([self::class, 'show'], ['member' => $member]);
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
