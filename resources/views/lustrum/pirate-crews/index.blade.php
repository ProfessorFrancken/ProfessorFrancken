@extends('layout.one-column-layout')

@section('main-content')
    <div class="container my-5">
        <div class="d-flex">
            @if ($crew->name === "Blue beards")
                <div>
                    <img src="{{ url('uploads/images/lustrum/bluebeardR-01.png') }}" alt="" class="img-fluid" width="200" height="200"/>
                </div>
            @endif
            <div class="p-3 mx-3 flex-grow-1">
                <h2 class="section-header">
                    {{ $crew->name }}
                </h2>

                <p class="lead my-3">
                    Total points earned this week: <strong>{{ $crew->total_points }}</strong>
                </p>

                @if ($crew->pirate_of_the_day)
                    <h3>Pirate of the day</h3>

                    <p class="lead ">
                        {{ $crew->pirate_of_the_day->name }}
                    </p>
                @endif
            </div>
            @if ($crew->name === "Red beards")
                <div>
                    <img src="{{ url('uploads/images/lustrum/redbeardL-01.png') }}" alt="" class="img-fluid" width="200" height="200"/>
                </div>
            @endif
        </div>


        <h3 class="mt-5">
            <i class="fas fa-users"></i>
            Crewmembers
        </h3>

        <ul class="list-unstyled">
            @foreach ($crew->crewMembers as $pirate)
                <li class="bg-light p-3 my-3 shadow-sm d-flex justify-content-between">
                    <h5 class="h6">
                        {{ $pirate->name }}
                    </h5>
                    <span>
                        {{ $pirate->total_points }}
                    </span>
                </li>
            @endforeach
        </ul>

        <h3 class="mt-5">
            <i class="fas fa-award"></i>
            Crew Adtchievements ({{ $crew->total_earned_adtchievements() }} / {{ $adtchievements->count() }})
        </h3>

        <ul class="list-unstyled">
            @foreach ($adtchievements as $adtchievement)
                @if ($adtchievement->isHiddenForCrew($crew))
                    <li class="bg-light p-3 my-3 shadow-sm">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="d-flex justify-content-between">
                                    Hidden adtchievement
                                </h4>
                                <p>
                                    No hints given here!
                                </p>
                            </div>
                            <div class="d-flex flex-column text-right">
                                @if ($adtchievement->is_repeatable)
                                    <i class="fas fa-redo text-muted my-1"></i>
                                @endif

                                @if ($adtchievement->is_team_effort)
                                    <i class="fas fa-users text-muted my-1"></i>
                                @endif
                            </div>
                        </div>
                    </li>
                @else
                    <li class="bg-light p-3 my-3 shadow-sm">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="d-flex justify-content-between align-items-center">
                                    {{ $adtchievement->title }}
                                    <small>
                                        ({{ $adtchievement->points }} points)
                                    </small>
                                </h4>
                                <p>
                                    {{ $adtchievement->description }}
                                </p>
                            </div>
                            <div class="d-flex flex-column text-right">
                                <span class="my-1">
                                    <strong>Total points:</strong> {{ $adtchievement->totalEarnedPointsBy($crew) }}
                                </span>
                                @if ($adtchievement->is_repeatable)
                                    <i class="fas fa-redo text-muted my-1"></i>
                                @endif

                                @if ($adtchievement->is_team_effort)
                                    <i class="fas fa-users text-muted my-1"></i>
                                @endif
                            </div>
                        </div>
                        <p>
                            <strong>Earned by</strong>
                            <small class="text-muted">
                                {{ $adtchievement->listEarnersOfCrew($crew) }}
                            </small>
                        </p>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
@endsection
