@extends('layout.two-column-layout')
@section('title', $activity->name . " - T.F.V. 'Professor Francken'")

@section('content')
    <div class="rounded shadow-sm">
        <div class="bg-white p-4 ">
            <div class="d-flex align-items-center">
                <div class="agenda-item__date align-self-start">
                    <h5 class="agenda-item__date-day">
                        {{ $activity->start_date->format('d') }}
                    </h5>
                    <span class="agenda-item__date-month">
                        {{ $activity->start_date->format('M') }}
                    </span>
                </div>
                <div class="agenda-item__body">
                    <h5 class="agenda-item__header">
                        {{ $activity->name }}
                    </h5>
                    <div class="d-flex flex-column justify-content-start">
                        @if ($activity->signUpSettings !== null)
                            @if (! $activity->signUpSettings->is_free)
                                <small class="text-muted font-weight-light d-block mt-2">
                                    <i class="fas fa-euro-sign"></i>
                                    {{ number_format($activity->signUpSettings->costs_per_person / 100, 2) }}

                                </small>
                            @endif
                        @endif
                        <small class="text-muted font-weight-light d-block mt-2">
                            <i class="fas fa-clock"></i>
                            {{ $activity->schedule }}
                        </small>
                        @if ($activity->location !== '')
                            <small class="text-muted font-weight-light d-block mt-2">
                                <i class="fas fa-map-marker"></i>
                                {{ $activity->location  }}
                            </small>
                        @endif
                    </div>
                </div>
            </div>
            <div class="mt-3">
                {!! $activity->compiled_content !!}
            </div>
        </div>

        @auth
        @if ($activity->signUpSettings !== null)
            <div class="bg-white pb-4 px-4 ">
                <h4 class="d-flex justify-content-between">
                    <span>
                        Sign ups
                    </span>
                    @if ($activity->signUpSettings->max_sign_ups === null)
                        <small class="mx-1 mb-0 text-muted">({{ $activity->totalSignUps }} / ∞)</small>
                    @else
                        <small class="mx-1 mb-0 text-muted">({{ $activity->totalSignUps }} / {{ $activity->signUpSettings->max_sign_ups }})</small>
                    @endif
                </h4>

                <ul class="list-unstyled mt-3">
                    @foreach ($activity->signUps as $signUp)
                        <li class="p-2 bg-light my-2 rounded d-flex justify-content-between align-items-center">
                            <span>
                                {{ $signUp->member->fullname }}
                                @if ($signUp->plus_ones > 0)
                                    (+{{ $signUp->plus_ones }})
                                @endif
                            </span>
                            <div>
                                @if ($account->member_id === $signUp->member_id)
                                    <a
                                        class="btn btn-text py-0 text-muted"
                                        href="{{ action(
                                                     [\Francken\Association\Activities\Http\SignUpsController::class, 'edit'],
                                                     ['activity' => $activity, 'sign_up' => $signUp])
                                              }}"
                                    >
                                        <i class="fas fa-edit"></i>
                                        Edit
                                    </a>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            @if ($account !== null && $activity->memberCanSignUp($account->member))
                <div class="bg-light p-4 pt-0 border-top">
                    @include('association.activities.sign-ups._create')
                </div>
            @endif
        @endif
        @else
        <div class="bg-light p-4">
            <p class="text-center">
                Login to sign up for this activity and see other members that have signed up.
                <a
                    class="btn btn-text text-primary mt-4"
                    href="{{ action([\Francken\Auth\Http\Controllers\LoginController::class, 'showLoginForm']) }}"
                >
                    Click here to login
                </a>

            </p>

        </div>

        @endauth
    </div>
@endsection

@section('aside')
    <div class="agenda">
        <h3 class="section-header agenda-header">
            Calendar
        </h3>
        <ul class="agenda-list list-unstyled">
            <div class="agenda-item d-flex justify-content-between font-weight-bold mb-2 pb-2">
                @include('association.activities._sidebar-years', ['years' => $visibleYears])
            </div>
            @foreach ($months as $month)
                @include('association.activities._sidebar-month', [
                    'year' => $selectedYear, 'month' => $month
                    ])
            @endforeach
        </ul>
    </div>
@endsection
