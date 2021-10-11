@extends('admin.layout')
@section('page-title', 'Members')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header p-0">
                    <ul class="nav nav-tabs card-header-tabs m-0">
                        @component('admin.association.members._tab-navigation', ['request' => $request, 'select' => 'all', 'class' => 'border-left-0'])
                            All members
                            <span class="badge badge-secondary text-white">
                                {{ $all_members }}
                            </span>
                        @endcomponent
                        @component('admin.association.members._tab-navigation', ['request' => $request, 'select' => 'new'])
                            New members
                            <span class="badge badge-secondary text-white">
                                {{ $new_members }}
                            </span>
                        @endcomponent
                        @component('admin.association.members._tab-navigation', ['request' => $request, 'select' => 'current-active-members'])
                            Current active members
                            <span class="badge badge-secondary text-white">
                                {{ $current_active_members }}
                            </span>
                        @endcomponent
                        @component('admin.association.members._tab-navigation', ['request' => $request, 'select' => 'active-members'])
                            Active members
                            <span class="badge badge-secondary text-white">
                                {{ $active_members }}
                            </span>
                        @endcomponent
                        @if (1 == 2)
                        @component('admin.association.members._tab-navigation', ['request' => $request, 'select' => 'alumni'])
                            Alumni
                            <span class="badge badge-secondary text-white">
                                {{ $alumni_members }}
                            </span>
                        @endcomponent
                        @endif
                        @component('admin.association.members._tab-navigation', ['request' => $request, 'select' => 'cancelled-membership'])
                            Cancelled membership
                            <span class="badge badge-secondary text-white">
                                {{ $cancelled_membership }}
                            </span>
                        @endcomponent
                    </ul>
                </div>

                @if ($request->selected('new'))
                    <div class="card-body">
                        <strong>New members</strong>: This table shows members who registered in the past year.
                    </div>
                @endif
                @if ($request->selected('current-active-members'))
                    <div class="card-body">
                        <strong>Current active members</strong>: This table only shows members who are in an active committee.
                    </div>
                @endif
                @if ($request->selected('active-members'))
                    <div class="card-body">
                        <strong>Active members</strong>: This table shows all members who joined one or more committees in the past.
                    </div>
                @endif
                @if ($request->selected('alumni'))
                    <div class="card-body">
                        <strong>Alumni</strong>: Not implemented, sorry
                    </div>
                @endif
                @if ($request->selected('cancelled-membership'))
                    <div class="card-body">
                        <strong>Cancelled membership</strong>: Members that have cancelled their membership
                    </div>
                @endif

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Member</th>
                            <th>Email</th>
                            <th>Study</th>
                            <th>Last updated at</th>
                            <th class="text-right">Show</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($members as $member)
                            <tr class="subscription">
                                <td  class="text-muted">
                                    {{ $member->id }}
                                </td>
                                <td>
                                    <div>
                                        {{ $member->fullname  }}
                                    </div>
                                    <div>
                                        {{ $member->type_lid  }}
                                    </div>
                                </td>
                                <td>
                                    {{ $member->emailadres }}
                                </td>
                                <td>
                                    <div>
                                        {{ $member->studierichting  }}
                                    </div>
                                    <small>
                                        {{ $member->studentnummer  }}
                                    </small>
                                </td>
                                <td>
                                    {{ $member->updated_at->diffForHumans()  }}
                                </td>
                                <td class="text-right">
                                    <a href="{{ action([\Francken\Association\Members\Http\Controllers\Admin\MembersController::class, 'show'], ['member' => $member])  }}" class="text-muted">
                                        <i class="far fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="card-footer">
                    {!! $members->links() !!}
                </div>
            </div>

        </div>
        <div class="col-3">
            @include('admin.association.members._search', ['request' => $request])
        </div>
    </div>
    
@endsection

@section('actions')
    <div class="d-flex align-items-start">
        @can('dashboard:members-read')
            <a href="{{ action([\Francken\Association\Members\Http\Controllers\RegistrationController::class, 'index']) }}"
                class="btn btn-primary mr-3"
            >
                <i class="fas fa-plus"></i>
                Add member
            </a>
        @endcan
    </div>
@endsection
