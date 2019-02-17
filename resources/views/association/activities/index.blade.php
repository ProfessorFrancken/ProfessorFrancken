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
            <li class="d-flex d-flex align-items-center mb-4 bg-white p-4 rounded" style="box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.125)">
                <div class=" d-flex d-flex align-items-center">
                    <div class="agenda-item__date align-self-start">
                        <h5 class="agenda-item__date-day">{{ $activity->startDate()->format('d') }}</h5>
                        <span class="agenda-item__date-month">{{ $activity->startDate()->format('M') }}</span>
                    </div>
                    <div class="agenda-item__body">
                        <h5 class="agenda-item__header">{{ $activity->title() }}</h5>
                        <p class="agenda-item__description">
                            {!! $activity->description() !!}
                        </p>
                        <small class="mt-1 text-muted font-weight-light d-block">
                            <i class="fas fa-clock"></i>
                            {{ $activity->schedule() }}
                        </small>
                        @if ($activity->location() !== '')
                            <small class="mt-1 text-muted font-weight-light">
                                <i class="fas fa-map-marker"></i>
                                {{ $activity->location()  }}
                            </small>
                        @endif
                    </div>
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
