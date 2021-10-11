@extends('admin.layout')
@section('page-title', 'Registration requests')

@section('content')
    <div class="card">
        <div class="card-header p-0">
            <ul class="nav nav-tabs card-header-tabs m-0">
                @component('admin.registration-requests._tab-navigation', ['request' => $request, 'select' => 'open', 'class' => 'border-left-0'])
                    Open requests
                    <span class="badge badge-secondary text-white">
                        {{ $open_requests  }}
                    </span>
                @endcomponent
                @component('admin.registration-requests._tab-navigation', ['request' => $request, 'select' => 'approved-not-signed'])
                    Approved but not signed
                    <span class="badge badge-secondary text-white">
                        {{ $approved_not_signed_requests  }}
                    </span>
                @endcomponent
                @component('admin.registration-requests._tab-navigation', ['request' => $request, 'select' => 'approved'])
                    Approved requests
                    <span class="badge badge-secondary text-white">
                        {{ $approved_requests  }}
                    </span>
                @endcomponent
                @component('admin.registration-requests._tab-navigation', ['request' => $request, 'select' => 'all'])
                    All
                    <span class="badge badge-secondary text-white">
                        {{ $all_requests  }}
                    </span>
                @endcomponent
            </ul>
        </div>

        <table class="table table-hover">
            <caption class="card-body">
                Open registration requests, you can either inspect a request (and possibly complete the registration), or mark it as spam in which case the request will be deleted.
            </caption>
            <thead>
                <tr>
                    <th>Fullname</th>
                    <th class="text-right">Submited at</th>
                    <th class="text-right">Form signed at</th>
                    <th class="text-right">Approved at</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requests as $request)
                    <tr>
                        <th scope="row">
                            <a href="{{ action(
                                        [\Francken\Association\Members\Http\Controllers\Admin\RegistrationRequestsController::class, 'show'],
                                        ['registration' => $request]
                                        )}}">
                                <div>
                                    {{ $request->fullname->toString() }}
                                </div>
                                <small>
                                    {{ $request->email->toString() }}
                                    @if ($request->email_verified_at === null)
                                        <small class="text-danger font-weight-bold">(not yet verified)</small>
                                    @endif
                                </small>
                            </a>
                        </th>
                        <td class="text-right">
                            {{ $request->created_at->format('Y-m-d') }}
                        </td>
                        <td class="text-right">
                            {{ optional($request->registration_form_signed_at)->format('Y-m-d') }}
                        </td>
                        <td class="text-right">
                            {{ optional($request->registration_accepted_at)->format('Y-m-d') }}
                        </td>
                        <td class="text-right">
                            <a class="btn btn-outline-success" href="{{ action(
                                        [\Francken\Association\Members\Http\Controllers\Admin\RegistrationRequestsController::class, 'show'],
                                        ['registration' => $request]
                                        )}}">
                                <i class="fa fa-search" aria-hidden="true"></i>
                                Inspect
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="card-footer">
            {{ $requests->links() }}
        </div>
    </div>
@endsection

@section('actions')
    <div class="d-flex align-items-start">
        <a href="{{ action([\Francken\Association\Members\Http\Controllers\RegistrationController::class, 'index']) }}"
            class="btn btn-primary mr-3"
        >
            <i class="fas fa-plus"></i>
            Add registration
        </a>
    </div>
@endsection
