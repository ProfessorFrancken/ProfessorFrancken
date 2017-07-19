@extends('career.index')
@section('header-image-url', '/images/header/oslo.jpg')
@section('title', "Career events - T.F.V. 'Professor Francken'")

@section('board-year-navigation')
    <ol class="list-inline academic-year-list">
        <li class="list-inline-item">

            {{-- Check if current $year is the current year --}}

            @if ($showNextYear)
            <a href="/career/events/{{ str_slug($year->nextYear()->toString()) }}" class="academic-year-list__item">
                {{ $year->nextYear()->toString() }}
            </a>
            @else
            <a href="#" class="academic-year-list__item academic-year-list__item--disabled" title="Currently we don't have any excursions planned for the academic year of 2018 - 2019">
                {{ $year->nextYear()->toString() }}
            </a>
            @endif
        </li>
        <li class="list-inline-item">

            <strong class="academic-year-list__item academic-year-list__item--active">
                {{ $year->toString() }}
            </strong>
        </li>
        <li class="list-inline-item">
            <a href="/career/events/{{ str_slug($year->previousYear()->toString()) }}" class="academic-year-list__item">

                {{ $year->previousYear()->toString() }}
            </a>
        </li>
    </ol>
@endsection

@section('content')
    <h1 class="section-header section-header--centered" id="excursions">
        Career Events
    </h1>

    <p class="lead">
        At T.F.V. 'Professor Francken' we organize many excursions.
        Below you'll find a list of past and planned excursions for the Academic Year of {{ $year->toString() }} and previously organized excursions.
    </p>

    @yield('board-year-navigation')

    @if (count($plannedEvents) > 0)
        <h2 class="text-center">
            Planned events
        </h2>

        <ul class="list-unstyled">

            @foreach ($plannedEvents as $excursion)
                @include('career._event', ['excursion' => $excursion])
            @endforeach
        </ul>
    @endif

    @if (count($pastEvents) > 0)
        <h2 class="text-center">
            Past events
        </h2>

        <ul class="list-unstyled">

            @foreach ($pastEvents as $excursion)
                @include('career._event', ['excursion' => $excursion])
            @endforeach
        </ul>
    @endif

    @if (count($pastEvents) == 0 && count($plannedEvents) == 0)
        <p class="text-center">
            We don't have any data for this academic year.
        </p>
    @endif

    @yield('board-year-navigation')
@endsection
