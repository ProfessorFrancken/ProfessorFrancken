@extends('admin.layout')
@section('page-title', 'Registration requests / ' . $registration->fullname->toString())

{{-- TODO:

           Comments / questions:

           This person wants to join a committee, send them an email asking which!

           --}}
@section('content')
    <p>
        When printing the registration form make sure that, when usign Google Chrome, to set the <em>Margins</em> to <em>None</em> and enable <em>Background graphics</em>.
    </p>

    <div class="card">
        <div class="card-body">
            <!-- <div class="bg-white p-4 rounded"> -->
            @include('registration.show._personal-details', ['registration' => $registration])
            @include('registration.show._contact-details', ['registration' => $registration])
            @include('registration.show._study-details', ['registration' => $registration])
            @include('registration.show._billing-details', ['registration' => $registration])
        </div>

        <div class="card-footer">
                <h4>
                    <i class="fas fa-signature"></i>
                    Sign registration form
                </h4>
            @if ($registration->registration_form_signed_at === null)
                <p>
                    Use this action to let our system know that the member has signed the printed registration form.
                </p>
                {!!
                   Form::model(
                       $registration,
                       [
                           'url' => action(
                               [\Francken\Association\Members\Http\Controllers\Admin\RegistrationRequestsController::class, 'sign'],
                               ['registration' => $registration->id]
                           ),
                           'method' => 'post'
                       ]
                   )
                !!}
                <button
                    type="submit"
                    class="btn btn-outline-success"
                    onClick='return confirm("Are you sure you want to approve this registration request?");'
                >
                    Sign registration form
                </button>

                {!! Form::close() !!}
            @else
                <p>
                    The registration form was signed {{ $registration->registration_form_signed_at->diffForHumans() }}
                </p>
            @endif
        </div>
        <div class="card-footer">
            @if ($registration->registration_accepted_at === null)
                <h4>
                    <i class="fas fa-check"></i>
                    Approve membership
                </h4>
                <p>
                    Once all information has been checked you can approve this person's membership.
                </p>
                {!!
                   Form::model(
                       $registration,
                       [
                           'url' => action(
                               [\Francken\Association\Members\Http\Controllers\Admin\RegistrationRequestsController::class, 'approve'],
                               ['registration' => $registration->id]
                           ),
                           'method' => 'post'
                       ]
                   )
                !!}
                <button
                    type="submit"
                    class="btn btn-outline-success"
                    onClick='return confirm("Are you sure you want to approve this registration request?");'
                >
                    Approve
                </button>

                {!! Form::close() !!}
            @endif
        </div>
    </div>

    {!!
       Form::model(
           $registration,
           [
               'url' => action(
                   [\Francken\Association\Members\Http\Controllers\Admin\RegistrationRequestsController::class, 'remove'],
                   ['registration' => $registration->id]
               ),
               'method' => 'post'
           ]
       )
    !!}
    @method('DELETE')

    <p class="mt-2 text-muted d-flex align-items-center justify-content-end">
        Click <button
                  class="btn btn-text px-1"
                  onclick='return confirm("Are you sure you want to remove this registration request?");'
              >here</button> to remove this registration.
    </p>

    {!! Form::close() !!}
@endsection

@section('actions')
    @if ($registration->registration_accepted_at === null)
    <div class="d-flex align-items-start">
        <a
            class="btn btn-outline-primary mr-3"
            href="{{ action(
                       [\Francken\Association\Members\Http\Controllers\Admin\RegistrationRequestsController::class, 'print'],
                       ['registration' => $registration->id]
                   ) }}"
            target="_blank"
        >
            <i class="fas fa-print"></i>
            Print
        </a>
        <a
            class="btn btn-outline-primary"
            href="{{ action(
                       [\Francken\Association\Members\Http\Controllers\Admin\RegistrationRequestsController::class, 'edit'],
                       ['registration' => $registration->id]
                   ) }}"
        >
            <i class="fas fa-user-edit"></i>
            Edit
        </a>
    </div>
    @endif
@endsection
