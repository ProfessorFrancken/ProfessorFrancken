@extends('admin.layout')
@section('page-title', 'Registration requests')

@section('content')
    <div class="card">
        <table class="table table-hover">
            <caption class="card-body">
                Open registration requests, you can either inspect a request (and possibly complete the registration), or mark it as spam in which case the request will be deleted.
            </caption>
            <thead>
                <tr>
                    <th>Fullname</th>
                    <th class="text-right">Subbmited at</th>
                    <th class="text-right">Form signed at</th>
                    <th class="text-right">Approved at</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requests as $request)
                    <tr>
                        <th scope="row">
                            <div>
                                {{ $request->fullname->toString() }}
                            </div>
                            <small>
                                {{ $request->email->toString() }}
                                @if ($request->email_verified_at === null)
                                    <small class="text-danger font-weight-bold">(not yet verified)</small>
                                @endif
                            </small>
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
                            <a class="btn btn-outline-success" href="/admin/association/registration-requests/{{ $request->id }}">
                                <i class="fa fa-search" aria-hidden="true"></i>
                                Inspect
                            </a>

                            {!! Form::open(['url' => '/admin/association/registration-requests/' . $request->id, 'method' => 'delete', 'class' => 'd-inline']) !!}

                            <button class="btn btn-link text-danger btn-xs">
                                <i class="fas fa-trash-alt" aria-hidden="true"></i>
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
