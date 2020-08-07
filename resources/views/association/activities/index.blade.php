@extends('layout.two-column-layout')


{{-- pagination in titel! --}}
@if($searchTimeRange)

    @section('title', 'Activities in ' . ($selectedMonth ? $selectedMonth . ' ' : '')  . $selectedYear)
    @section('description', 'Activiteiten in ' . ($selectedMonth ? $selectedMonth . ' ' : '') . $selectedYear)
@else
    @section('title', "Upcoming activities - T.F.V. 'Professor Francken'")
@endif

@section('content')
    @if($searchTimeRange)
        <h1 class="section-header mb-4">Activities in {{ $selectedDate->format('F \'y')}}</h1>
    @else
        <h1 class="section-header mb-4">Upcoming activities</h1>
    @endif

    <ul class="agenda-list list-unstyled">
        @forelse ($activities as $activity)
            <li class=" mb-4 bg-white p-4 rounded shadow-sm">
                <a href="{{ action([\Francken\Association\Activities\Http\ActivitiesController::class, 'show'], ['activity' => $activity]) }}">
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
                </a>
                <div class="d-none">
                <div class="mt-3">
                    {!! $activity->compiled_content !!}
                </div>
                @if ($activity->signUpSettings !== null)
                    <div class="mt-4">
                        <h6 class="font-weight-light">
                            Sign ups
                            @if ($activity->signUpSettings->max_sign_ups === null)
                                <small class="mx-1 mb-0 text-muted">({{ $activity->totalSignUps }} / ∞)</small>
                            @else
                                <small class="mx-1 mb-0 text-muted">({{ $activity->totalSignUps }} / {{ $activity->signUpSettings->max_sign_ups }})</small>
                            @endif
                        </h6>

                        <ul class="list-unstyled mt-2">
                            @foreach ($activity->signUps as $signUp)
                                <li class="p-2 bg-light my-2 rounded">
                                    {{ $signUp->member->fullname }}
                                    @if ($signUp->plus_ones > 0)
                                        (+{{ $signUp->plus_ones }})
                                    @endif
                                </li>
                            @endforeach
                        </ul>

                        @if ($activity->registration_deadline->isFuture())
                            <p>
                            Sign up deadline ends in {{ $activity->registration_deadline->diffForHumans() }}
                        </p>
                        @endif
                    </div>
                @endif
                </div>
            </li>
        @empty
            <li class="d-flex d-flex align-items-center mb-4 bg-white p-4 rounded" style="box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.125)">
                <div class="agenda-item__body">
                    <h5 class="agenda-item__header">No planned activities in this period</h5>
                </div>
            </li>
        @endforelse
    </ul>
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
