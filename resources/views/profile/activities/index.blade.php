@extends('profile.layout')

@section('content')
    <div class="d-flex justify-content-between">
        <h4 class="font-weight-bold section-header">
            Activities
        </h4>
    </div>

    <ul class="list-unstyled mt-3">
        @foreach ($activities as $activity)
            @php
            $signUp = $activity->signUps->where('member_id', $member->id)->first();
            @endphp
            <li class=" mb-4 bg-white p-4 rounded shadow-sm">
                <div class="d-flex align-items-center">
                    <div class="agenda-item__date align-self-start">
                        <h5 class="agenda-item__date-day">
                            {{ $activity->start_date->format('d') }}
                        </h5>
                        <span class="agenda-item__date-month">
                            {{ $activity->start_date->format('M') }}
                        </span>
                    </div>
                    <div class="agenda-item__body w-100">
                        <div class="d-flex justify-content-between">
                            <a href="{{ action([\Francken\Association\Activities\Http\ActivitiesController::class, 'show'], ['activity' => $activity]) }}">
                                <h5 class="agenda-item__header">
                                    {{ $activity->name }}
                                </h5>
                            </a>
                            @can('update', $signUp)
                            <div>
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
                            </div>
                            @endcan
                        </div>
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
            </li>
        @endforeach
    </ul>

    {!! $activities->links() !!}

@endsection
