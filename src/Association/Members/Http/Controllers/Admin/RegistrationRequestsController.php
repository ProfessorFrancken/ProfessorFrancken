<?php

declare(strict_types=1);

namespace Francken\Association\Members\Http\Controllers\Admin;

use Francken\Association\Boards\BoardMember;
use Francken\Association\Boards\BoardMemberStatus;
use Francken\Association\Members\Http\Requests\AdminSearchRegistrationRequest;
use Francken\Association\Members\Http\Requests\RegistrationRequest;
use Francken\Association\Members\Registration\Registration;
use Francken\Shared\Clock\Clock;
use Francken\Shared\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Webmozart\Assert\Assert;

final class RegistrationRequestsController extends Controller
{
    public function index(AdminSearchRegistrationRequest $request) : View
    {
        $requests = Registration::orderBy('created_at', 'desc')
            ->when(
                $request->selected('open'),
                fn ($query) => $query->whereNull('registration_accepted_at')
            )
            ->when(
                $request->selected('approved-not-signed'),
                fn (Builder $query) : Builder => $query->whereNotNull('registration_accepted_at')->whereNotNull('registration_form_signed_at')
            )
            ->when(
                $request->selected('approved'),
                fn (Builder $query) : Builder => $query->whereNotNull('registration_accepted_at')
            )
            ->paginate()
            ->appends($request->except('page'));

        return view('admin.registration-requests.index', [
            'requests' => $requests,
            'request' => $request,

            'all_requests' => Registration::query()->count(),
            'open_requests' => Registration::query()->whereNull('registration_accepted_at')->count(),
            'approved_requests' => Registration::query()->whereNotNull('registration_accepted_at')->count(),
            'approved_not_signed_requests' => Registration::query()->whereNotNull('registration_accepted_at')->whereNotNull('registration_form_signed_at')->count(),

            'breadcrumbs' => [
                ['url' => action([self::class, 'index']), 'text' => 'Registration requests'],
            ]
        ]);
    }

    public function show(Registration $registration) : View
    {
        return view('admin.registration-requests.show', [
            'registration' => $registration,
            'breadcrumbs' => [
                ['url' => action([self::class, 'index']), 'text' => 'Registration requests'],
                ['url' => action([self::class, 'show'], ['registration' => $registration->id]), 'text' => $registration->fullname->toString()],
            ]
        ]);
    }

    public function edit(Registration $registration) : View
    {
        return view('admin.registration-requests.edit', [
            'registration' => $registration,
            'amountOfStudies' => count($registration->studies) - 1,
            'breadcrumbs' => [
                ['url' => action([self::class, 'index']), 'text' => 'Registration requests'],
                ['url' => action([self::class, 'show'], ['registration' => $registration->id]), 'text' => $registration->fullname->toString()],
                ['url' => action([self::class, 'edit'], ['registration' => $registration->id]), 'text' => 'Edit'],
            ]
        ]);
    }

    public function print(Registration $registration) : View
    {
        $mostRecentStudy = $registration->most_recent_study;
        $startingDateStudy = optional(optional($mostRecentStudy)->startDate())->format("Y");

        return view('admin.registration-requests.print', [
            'registration' => $registration,
            'study' => optional($mostRecentStudy)->study(),
            'starting_date_study' => $startingDateStudy,
        ]);
    }

    public function update(RegistrationRequest $request, Registration $registration) : RedirectResponse
    {
        $registration->personal_details = $request->personalDetails();
        $registration->contact_details = $request->contactDetails();
        $registration->study_details = $request->studyDetails();
        $registration->payment_details = $request->paymentDetails();
        $registration->comments = $request->notes();
        $registration->wants_to_join_a_committee = $request->wantsToJoinACommittee();
        $registration->save();

        return redirect()->action([self::class, 'show'], ['registration' => $registration->id])
            ->with([
                'status' => 'Successfully updated request from ' . $registration->fullname->toString()
            ]);
    }

    public function remove(Registration $registration) : RedirectResponse
    {
        $registration->delete();

        return redirect()->action([self::class, 'index'])
            ->with([
                'status' => 'Successfully archived request from ' . $registration->fullname->toString()
            ]);
    }

    public function approve(Registration $registration, Clock $clock) : RedirectResponse
    {
        $account = auth()->user();
        Assert::notNull($account);

        /** @var BoardMember|null $boardMember */
        $boardMember = BoardMember::whereMemberId($account->member_id)
            ->whereIn('board_member_status', [
                BoardMemberStatus::BOARD_MEMBER,
                BoardMemberStatus::DEMISSIONED_BOARD_MEMBER
            ])
            ->first();

        if ($boardMember === null) {
            abort(403, "Only a board member may approve registrations");
        }

        $registration->approve($boardMember, $clock->now());

        return redirect()->action([self::class, 'index'])
            ->with([
                'status' => 'Successfully approved registration from ' . $registration->fullname->toString()
            ]);
    }

    public function sign(Registration $registration, Clock $clock) : RedirectResponse
    {
        $account = auth()->user();
        Assert::notNull($account);

        $boardMember = BoardMember::whereMemberId($account->member_id)
            ->whereIn('board_member_status', [
                BoardMemberStatus::BOARD_MEMBER,
                BoardMemberStatus::DEMISSIONED_BOARD_MEMBER
            ])
            ->first();

        if ($boardMember === null) {
            abort(403, "Only a board member may sign registrations");
        }

        $registration->signRegistrationForm($clock->now());

        return redirect()->action([self::class, 'index'])
            ->with([
                'status' => 'Successfully signed registration form from ' . $registration->fullname->toString()
            ]);
    }
}
