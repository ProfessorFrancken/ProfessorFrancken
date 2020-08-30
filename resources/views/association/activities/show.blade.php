@extends('layout.two-column-layout')
@section('title', $activity->name . " - T.F.V. 'Professor Francken'")

@section('content')
    <div class="rounded shadow-sm">
        <div class="bg-white p-4 ">
            <h3 class="section-header">
                {{ $activity->name }}
            </h3>
            <div class="mt-3">
                {!! $activity->compiled_content !!}
            </div>
        </div>

        @auth
            @can('create', [\Francken\Association\Activities\SignUp::class, $activity])
            @if ($activity->signUpSettings !== null)
            <div class="bg-light p-4 pt-0 border-top">
                @include('association.activities.sign-ups._create')
            </div>
            @endif
            @endcan
        @else
            @if ($activity->signUpSettings !== null)
                <div class="text-primary lead text-center p-5" style="background-color: #f2f5f8 !important;">
                    @if ($activity->totalSignUps === 0)
                        <a
                            class=""
                            href="{{ action([\Francken\Auth\Http\Controllers\LoginController::class, 'showLoginForm']) }}"
                        >
                            Login
                        </a>
                        and be the first to sign up for this activity!
                    @else
                        {{ $activity->totalSignUps }} Franckenmembers are joining this activity,
                        <a
                            class=""
                            href="{{ action([\Francken\Auth\Http\Controllers\LoginController::class, 'showLoginForm']) }}"
                        >
                            login
                        </a>
                        and sign up as well.
                    @endif
                </div>
            @endif
        @endauth
    </div>

    @include('association.activities.comments._index')
@endsection

@section('aside')
    <div class="bg-white p-4 shadow-sm mb-5">
        <h4>
            About this event
        </h4>
        <div class="row my-3">
            <div class="col-4">
                <strong>From</strong>
            </div>
            <div class="col-8 text-right">
                {{ $activity->start_date->format("F jS") }}
                <small class="text-muted mx-1">
                    •
                </small>
                {{ $activity->start_date->format("H:i") }}
            </div>
        </div>

        <div class="row my-3">
            <div class="col-4">
                <strong>Until</strong>
            </div>
            <div class="col-8 text-right">
                {{ $activity->end_date->format("F jS") }}
                <small class="text-muted mx-1">
                    •
                </small>
                {{ $activity->end_date->format("H:i") }}
            </div>
        </div>


        @if ($activity->signUpSettings !== null)
            <div class="row my-3">
                <div class="col-4">
                    <strong>Registration deadline</strong>
                </div>
                <div class="col-8 text-right">
                    {{ $activity->signUpSettings->deadline_at->format("F jS") }}
                    <small class="text-muted mx-1">
                        •
                    </small>
                    {{ $activity->signUpSettings->deadline_at->format("H:i") }}
                </div>
            </div>

            <div class="row my-3">
                <div class="col-4">
                    <strong>Costs</strong>
                </div>
                <div class="col-8 text-right">
                    @if ($activity->signUpSettings->is_free)
                        Free
                    @else
                        &euro;
                        {{ number_format($activity->signUpSettings->costs_per_person / 100, 2) }}
                    @endif
                </div>
            </div>
        @endif

        <div class="row my-3">
            <div class="col-4">
                <strong>Location</strong>
            </div>

            <div class="col-8 text-right">
                {{ $activity->location }}
            </div>
        </div>
    </div>

    @if ($activity->signUpSettings !== null)
        <div class="bg-white p-4 shadow-sm mb-5">
            <div class="d-flex justify-content-between">
                <h4>
                    Attendees
                </h4>
                <div>
                    @if ($activity->signUpSettings->max_sign_ups === null)
                        <span class="mx-1 mb-0 text-muted">{{ $activity->totalSignUps }} / ∞</span>
                    @else
                        <span class="mx-1 mb-0 text-muted">{{ $activity->totalSignUps }} / {{ $activity->signUpSettings->max_sign_ups }}</span>
                    @endif
                </div>
            </div>

            @auth
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
                            @can('update', $signUp)
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
                            @endcan
                        </div>
                    </li>
                @endforeach
            </ul>
    @else
            <p>
                Login to see who has signed up.
            </p>
            @endauth
        </div>
    @endif
@endsection
