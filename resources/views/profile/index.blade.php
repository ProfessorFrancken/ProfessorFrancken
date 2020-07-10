@extends('profile.layout')

@section('content')
    <div class="d-flex justify-content-between">
        <h4 class="font-weight-bold section-header">
            {{ $member->fullname }} ({{ $member->initials }} {{ $member->surname }})
        </h4>
        <div class="text-right d-flex justify-content-between">
            <p class="text-muted mx-3">
                @if ($member->gender === \Francken\Association\Members\Gender::FEMALE)
                    <i class="fas fa-venus"></i>
                @elseif ($member->gender === \Francken\Association\Members\Gender::MALE)
                    <i class="fas fa-mars"></i>
                @else
                    {{ $member->gender }}
                @endif
            </p>
            <p class="text-muted ml-3">
                <i class="fas fa-birthday-cake"></i>
                {{ $member->birthdate->format('Y-m-d') }}
            </p>
        </div>
    </div>

    <div class="card my-3">
        <div class="card-body">
            <a href="" class="float-right text-muted d-none">
                <i class="fas fa-edit"></i>
                Edit
            </a>
            <h5 class="">
                <i class="fas fa-envelope-open-text"></i>
                Email
            </h5>
            <p class="mb-0">
                {{ $member->email }}
            </p>
            @if ($member->address)
                <h5 class="mt-4">
                    <i class="fas fa-map-marker-alt"></i>
                    Address
                </h5>
                <address class="mb-0 mt-2">
                    {{ $member->address->city() }}
                    <br/>
                    {{ $member->address->postalCode() }} {{ $member->address->address() }}
                    <br/>
                    {{ $member->address->country() }}
                </address>
            @endif
            @if ($member->phone_number !== null)
                <h5 class="mt-4">
                    <i class="fas fa-mobile"></i>
                    Phonenumber
                </h5>
                <p class="mb-0 mt-2">
                    {{ $member->phone_number }}
                </p>
            @endif
        </div>
    </div>

    <div class="card my-3">
        <div class="card-body">
            <a href="" class="float-right text-muted d-none">
                <i class="fas fa-edit"></i>
                Edit
            </a>
            <h5>
                <i class="fas fa-graduation-cap"></i>
                <strong>
                    Student number
                </strong>:
                <span class="font-weight-light">
                    {{ $member->student_number }}
                </span>
            </h5>
            <ul class="list-unstyled">
                @foreach ($member->student->studies() as $study)
                    <li class="my-3 bg-light p-3">
                        <h6 class="mb-0">
                            {{ $study }}
                        </h6>
                        {{ $study->startYear() }} - {{ $study->endYear() }}
                    </li>
                @endforeach
            </ul>
        </div>

    </div>
    <div class="card my-3">
        <div class="card-body">
            <a href="" class="float-right text-muted d-none">
                <i class="fas fa-edit"></i>
                Edit
            </a>
            <h5>
                <i class="fas fa-money-check-alt"></i>
                Finances
            </h5>

            <p>
                You've authorized T.F.V. 'Professor Francken' to withdraw money from the bank account listed above, due to:
            </p>
            <ul class="list-unstyled">
                @if (! $member->gratis_lidmaatschap)
                    <li>
                        <i class="far fa-check-square"></i>
                        Membership (€5,- per year)
                    </li>
                @endif
                <li>

                    @if ($member->payment_details->deductAdditionalCosts())
                        <i class="far fa-check-square"></i>
                    @else
                        <i class="far fa-square"></i>
                    @endif
                    Drinking and eating expenses and any potential costs incurred at other activities of the association.
                </li>
            </ul>
            <p>
                These costs will be deducted from {{ $member->payment_details->maskedIban() }}.
            </p>
        </div>
    </div>

    <div class="card my-3">
        <div class="card-body">
            <h5>
                <i class="fas fa-key"></i>
                Password
            </h5>
            <p>
                Click <a href="/" class="font-weight-bold">here</a> to change your password.
            </p>
        </div>
    </div>

    @if ($committees->isNotEmpty())
        <div class="card my-3">
            <div class="card-body">
                <h5>
                    <i class="fas fa-users"></i>
                    Committees
                </h5>

                <ul class="list-unstyled">
                    @foreach ($committees as $committee)
                        <li class="my-3 bg-light p-3">
                            <a href="{{ action(
                                            [\Francken\Association\Committees\Http\CommitteesController::class, 'show'],
                                            ['board' => $committee->board, 'committee' => $committee]
                                            ) }}"
                                class="d-flex justify-content-start align-items-center text-left"
                            >
                                <img
                                    class="rounded text-left mr-2"
                                    src="{{ $committee->logo }}"
                                    style="
                                    width: 50px;
                                    max-width: 50px;
                                    max-height: 40px;
                                    object-fit: contain;"
                                />

                                <div class="d-flex flex-column justify-content-between" >
                                    <span class="font-weight-bold">
                                        {{ $committee->name }}
                                    </span>

                                    <small class="text-muted">
                                        {{ $committee->board->board_name->toString() }}
                                        ({{ $committee->board->board_year->toString() }})
                                    </small>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    @if (1 == 2)
        @component('profile._profile', ['icon' => 'fas fa-user-secret'])
            <h6 class="text-body font-weight-light">
                Privacy settings
            </h6>

            <ul class="list-unstyled">
                <li>
                    <i class="fas fa-check fa-xs text-primary"></i> Let others know what activities I've signed up
                </li>
                <li>
                    <i class="fas fa-check fa-xs text-primary"></i> Share my <em>streep-statistics</em> on <a href="https://borrelcie.vodka">borrelcie.vodka</a>.
                </li>
                <li>
                    <i class="fas fa-check fa-xs text-primary"></i> Track my phone location in the Francken Room
                </li>
            </ul>
        @endcomponent
    @endif
@endsection
