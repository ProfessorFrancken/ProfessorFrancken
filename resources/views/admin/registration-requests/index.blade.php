@extends('admin.layout')
@section('page-title', 'Registration requests')

@section('content')
    @if (session('status'))
        <p class="alert alert-success mb-3">
            {{ session('status') }}
        </p>
    @endif

    <div class="card">
        <table class="table table-hover">
            <caption class="card-body">
                Open registration requests, you can either inspect a request (and possibly complete the registration), or mark it as spam in which case the request will be deleted.
            </caption>
            <thead>
                <tr>
                    <th>Fullname</th>
                    <th>Personal Info</th>
                    <th>Contact Info</th>
                    <th>Study Info</th>
                    <th>Payment Info</th>
                    <th>Subbmited at</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requests as $request)
                    <tr class="{{ $request->complete() ? 'success' : '' }}" >
                        <th scope="row">{{ $request->requestee() }}</th>
                        <td>
                            <i class="fa {{ $request->hasPersonalInfo() ? 'fa-check-circle-o' : 'fa-circle-o' }}" aria-hidden="true"></i>
                        </td>
                        <td>
                            <i class="fa {{ $request->hasContactInfo() ? 'fa-check-circle-o' : 'fa-circle-o' }}" aria-hidden="true"></i>
                        </td>
                        <td>
                            <i class="fa {{ $request->hasStudyInfo() ? 'fa-check-circle-o' : 'fa-circle-o' }}" aria-hidden="true"></i>
                        </td>
                        <td>
                            <i class="fa {{ $request->hasPaymentInfo() ? 'fa-check-circle-o' : 'fa-circle-o' }}" aria-hidden="true"></i>
                        </td>
                        <td>
                            {{ $request->submittedAt()->format('Y-m-d') }}
                        </td>
                        <td>
                            <a class="btn btn-outline-success" href="/admin/association/registration-requests/{{ $request->id() }}">
                                <i class="fa fa-search" aria-hidden="true"></i>
                                Inspect
                            </a>

                            {!! Form::open(['url' => '/admin/association/registration-requests/' . $request->id(), 'method' => 'delete', 'class' => 'd-inline']) !!}

                            <button class="btn-link text-danger btn-xs">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                Mark as spam
                            </button>

                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
