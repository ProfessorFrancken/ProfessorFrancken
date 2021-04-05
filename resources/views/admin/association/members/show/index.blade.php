@extends('admin.layout')
@section('page-title', 'Members ' . ' / ' . $member->fullname)

    @section('content')
        @include('admin.association.members.show._summary', ['member' => $member, 'boardMembers' => $boardMembers, 'currentCommittees' => $currentCommittees])

        <div class="row">
            <div class="col">
                <div class="card mb-3">
                    <div class="card-body">
                        @include('admin.association.members.show._personal-details', ['member' => $member])
                        @include('admin.association.members.show._contact-details', ['member' => $member])
                        @include('admin.association.members.show._study-details', ['member' => $member])
                        @include('admin.association.members.show._other-details', ['member' => $member])
                    </div>
                </div>
            </div>

            <div class="col-4">
                @include('admin.association.members.show._boards', ['member' => $member, 'boardMembers' => $boardMembers])
                @include('admin.association.members.show._francken-vrij-subscription', ['member' => $member, 'subscription' => $subscription])
                @include('admin.association.members.show._consumption-counter', ['member' => $member, 'consumptionCounterExtra' => $consumptionCounterExtra])
                @include('admin.association.members.show._francken-account', ['member' => $member, 'account' => $account])
                @include('admin.association.members.show._notes', ['member' => $member])
                @include('admin.association.members.show._activities', ['member' => $member])
                @include('admin.association.members.show._committees', ['member' => $member, 'committeesByBoard' => $committeesByBoard])
                @include('admin.association.members.show._books', ['member' => $member])
                @include('admin.association.members.show._career', ['member' => $member])
            </div>
        </div>
@endsection

@section('actions')
    <div class="d-flex align-items-start">
        <a href="{{ action([\Francken\Association\Members\Http\Controllers\Admin\MembersController::class, 'edit'], ['member' => $member]) }}"
           class="btn btn-primary btn-sm"
        >
            <i class="fas fa-edit"></i>
            Edit
        </a>
    </div>
@endsection
