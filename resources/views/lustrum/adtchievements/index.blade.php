@extends('layout.one-column-layout')

@section('main-content')
    <div class="container my-5">
        <h2 class="section-header section-header--centered">
            Adtchievements
        </h2>

        <ul class="list-unstyled">
            @foreach ($adtchievements as $adtchievement)
                <li class="bg-light p-3 my-4 shadow-sm">
                    <div>
                    <strong>
                        {{ $adtchievement->pirate->name }}
                    </strong>
                    earned {{ $adtchievement->points }} points because they
                    {{ $adtchievement->adtchievement->past_tense }}
                    {{ $adtchievement->created_at->diffForHumans() }}
                    </div>
                    @if ($adtchievement->reason !== null && $adtchievement->reason !== "")
                        <strong>Reason</strong>: {{ $adtchievement->reason }}
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
@endsection
