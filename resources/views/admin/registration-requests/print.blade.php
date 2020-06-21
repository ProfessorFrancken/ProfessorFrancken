@extends('admin.print-layout')
@section('page-title', "T.F.V. 'Professor Francken'")
@section('corner')
    <h3 class="text-muted d-flex align-items-end mb-0 h4">
        <span>
        Member ID:
        </span>
        <small class="ml-3 border-bottom" style="min-width: 15ch">
            {{ $registration->member_id ?? '' }}
        </small>
    </h3>
@endsection

@section('footer')
    <div class="container-fluid mb-5">
        <div class="d-flex justify-content-between px-4">
            <h3 class="text-muted d-flex align-items-end mb-0 h4">
                <span>
                    Signature
                    <i class="fas fa-signature" aria-hidden="true"></i>
                </span>
                <small class="ml-3 border-bottom" style="min-width: 35ch"> </small>
            </h3>
            <h3 class="text-muted d-flex align-items-end mb-0 h4">
                <span>
                    Date
                </span>
                <small class="ml-3 border-bottom" style="min-width: 35ch"> </small>
            </h3>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-fluid mt-5 px-4">
        <div class="card px-3">
            <div class="card-body">
                <ul class="list-unstyled row">
                    <li class="my-3 col-6">
                        <i class="far fa-check-square"></i> I want to be a member of T.F.V. 'Professor Francken'
                    </li>
                    <li class="my-3 offset-1 col-4">
                        @if ($registration->wants_to_join_a_committee)
                            <i class="far fa-check-square"></i>
                        @else
                            <i class="far fa-square"></i>
                        @endif
                        I am interested in joining a committee
                    </li>
                </ul>

                <h4 class="mt-3">
                    <i class="fa fa-address-book" aria-hidden="true"></i>
                    Membership form
                </h4>
                <div class="row">
                    @include('admin.registration-requests._print-input', ['name' => 'Name', 'value' => $registration->fullname->firstname()])
                    @include('admin.registration-requests._print-input', ['name' => 'Surname', 'value' => $registration->fullname->surname()])
                </div>
                <div class="row">
                    @include('admin.registration-requests._print-input', ['name' => 'Initials', 'value' => $registration->initials])
                    @include('admin.registration-requests._print-input', ['name' => 'Date of birth', 'value' => $registration->birthdate->format("Y-m-d")])
                </div>
                <div class="row">
                    <div class="my-3 col-2">
                        <div class="text-right flex-grow-1">
                            Gender
                        </div>
                    </div>
                    <div class="my-3 col">
                        @if ($registration->gender === \Francken\Association\Members\Gender::FEMALE)
                            <i class="far fa-check-square"></i>
                        @else
                            <i class="far fa-square"></i>
                        @endif
                        Female
                    </div>
                    <div class="my-3 col">
                        @if ($registration->gender === \Francken\Association\Members\Gender::MALE)
                            <i class="far fa-check-square"></i>
                        @else
                            <i class="far fa-square"></i>
                        @endif
                        Male
                    </div>
                    <div class="my-3 col-2 text-right">
                        @if (! in_array($registration->gender, [\Francken\Association\Members\Gender::FEMALE, \Francken\Association\Members\Gender::MALE], true))
                            <i class="far fa-check-square"></i>
                        @else
                            <i class="far fa-square"></i>
                        @endif
                        Other
                    </div>
                    <span class="my-3 col-4">
                        <div class="border-bottom" style="min-width: {{ $chars ?? 35 }}ch">
                            @if (! in_array($registration->gender, [\Francken\Association\Members\Gender::FEMALE, \Francken\Association\Members\Gender::MALE], true))
                                {{ $registration->gender }}
                            @else
                                &nbsp;
                            @endif
                        </div>
                    </span>
                </div>
                <div class="row">
                    <div class="my-3 col-2">
                        <div class="text-right flex-grow-1">
                            High school diploma
                        </div>
                    </div>
                    <div class="my-3 col">
                        @if ($registration->has_dutch_diploma)
                            <i class="far fa-check-square"></i>
                        @else
                            <i class="far fa-square"></i>
                        @endif
                        Dutch
                    </div>
                    <div class="my-3 col">
                        @if (! $registration->has_dutch_diploma)
                            <i class="far fa-check-square"></i>
                        @else
                            <i class="far fa-square"></i>
                        @endif
                        Foreign
                    </div>
                    @include('admin.registration-requests._print-input', ['name' => 'Nationality', 'value' => $registration->nationality])
                </div>

                <h5 class="mt-4">
                    <i class="fa fa-home" aria-hidden="true"></i>
                    Contact details
                </h5>

                <div class="row">
                    @include('admin.registration-requests._print-input', ['name' => 'E-mail address', 'value' => $registration->email->toString()])
                </div>

                <div class="row">
                    @include('admin.registration-requests._print-input', ['name' => 'Address', 'value' => $registration->address])
                    @include('admin.registration-requests._print-input', ['name' => 'City', 'value' => $registration->city])
                </div>
                <div class="row">
                    @include('admin.registration-requests._print-input', ['name' => 'Postal code', 'value' => $registration->postal_code])
                    @include('admin.registration-requests._print-input', ['name' => 'Country', 'value' => $registration->country])
                </div>

                <div class="row">
                    @include('admin.registration-requests._print-input', ['name' => 'Phone number', 'value' => $registration->phone_number])
                </div>

                <p class="text-center mt-3 mb-5">
                    If you'd like to join the Whatsapp event promotion add <strong>+31 50 363 4978</strong> to your contacts and send "Francken ON" to this number.
                </p>

                <h5 clas="mt-4">
                    <i class="fa fa-graduation-cap" aria-hidden="true"></i>
                    Study details
                </h5>

                <div class="row">
                    @include('admin.registration-requests._print-input', ['name' => 'Study', 'value' => $study])
                    @include('admin.registration-requests._print-input', ['name' => 'Student number', 'value' => $registration->student_number])
                    @include('admin.registration-requests._print-input', ['name' => 'Starting date study', 'value' => $starting_date_study])
                </div>

                <h5 class="mt-4">
                    <i class="fas fa-money-check-alt" aria-hidden="true"></i>
                    Payment details
                </h5>

                <p>
                    I hereby give permission to T.F.V. 'Professor Francken' to withdraw money from the bank account listed below, due to:
                </p>
                <ul class="list-unstyled">
                    <li class="my-3">
                        @if ($registration->iban !== null)
                            <i class="far fa-check-square"></i>
                        @else
                            <i class="far fa-square"></i>
                        @endif
                        Membership (&euro;5,- per year, required in order to make this form valid)
                    </li>
                    <li class="my-3">
                        @if ($registration->iban !== null && $registration->deduct_additional_costs)
                            <i class="far fa-check-square"></i>
                        @else
                            <i class="far fa-square"></i>
                        @endif
                        Drinking and eating expenses and any potential costs incurred at other activities of the association. (Check if you want to buy food in the Franckenroom)
                    </li>
                </ul>
                <div class="row">
                @include('admin.registration-requests._print-input', ['name' => 'IBAN', 'value' => $registration->iban])
                </div>
            </div>
        </div>
        <div class="card d-none">
            <div class="card-body">
                <!-- <div class="bg-white p-4 rounded"> -->
                @include('registration.show._personal-details', ['registration' => $registration])
                @include('registration.show._contact-details', ['registration' => $registration])
                @include('registration.show._study-details', ['registration' => $registration])
                @include('registration.show._billing-details', ['registration' => $registration])
            </div>
        </div>
    </div>

    <p class="text-center my-4 text-muted">
        By signing this form you agree to the privacy statement of T.F.V. 'Professor Francken'
    </p>
@endsection
