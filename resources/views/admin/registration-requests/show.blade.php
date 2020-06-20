@extends('admin.layout')
@section('page-title', 'Registration requests / ' . $registration->fullname->toString())

{{-- TODO:

           Comments / questions:

           This person wants to join a committee, send them an email asking which!

           --}}
@section('content')
    <div class="card">

        <div class="card-body">
            <!-- <div class="bg-white p-4 rounded"> -->
            @include('registration.show._personal-details', ['registration' => $registration])
            @include('registration.show._contact-details', ['registration' => $registration])
            @include('registration.show._study-details', ['registration' => $registration])
            @include('registration.show._billing-details', ['registration' => $registration])
        </div>

        <div class="card-footer">
            <!-- <div class="bg-white p-4 rounded"> -->
            @if ($registration->registration_accepted_at === null)
                <h4>Approve membership</h4>
                <p>
                    Once all information has been checked you can approve this person's membership.
                </p>
                {!!
                   Form::model(
                       $registration,
                       [
                           'url' => action(
                               [\Francken\Association\Members\Http\Controllers\Admin\RegistrationRequestsController::class, 'approve'],
                               ['registation' => $registration->id]
                           ),
                           'method' => 'post'
                       ]
                   )
                !!}

                {!! Form::submit('Approve', ['class' => 'btn btn-outline-success', 'onClick' => 'return confirm("Are you sure you want to approve this registration request?");']) !!}
                {!! Form::close() !!}
            @endif
        </div>
    </div>
@endsection

@section('actions')
    @if ($registration->registration_accepted_at === null)
    <div class="d-flex align-items-end">
        <a
            class="btn btn-outline-primary mr-3"
            href="{{ action(
                       [\Francken\Association\Members\Http\Controllers\Admin\RegistrationRequestsController::class, 'edit'],
                       ['registration' => $registration->id]
                   ) }}"
        >
            Edit
        </a>
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

        {!! Form::submit('Remove', ['class' => 'btn btn-outline-danger', 'onClick' => 'return confirm("Are you sure you want to remove this registration request?");']) !!}
        {!! Form::close() !!}
    </div>
    @endif
@endsection
