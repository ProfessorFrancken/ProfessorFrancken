@extends('lustrum.tv.layout')

@section('content')
    <div
        style="
               background-image: url({{ url('uploads/images/lustrum/lustrum-ocean.jpeg') }});
               background-size: cover;

               "
    >
    <div class="d-flex justify-content-between align-items-center p-5" style="height: 100vh; width: 100vw; text-shadow: 3px 0px #fff, -3px 0px #fff, 0px 3px #fff, 0px -3px #fff, 3px 3px #fff, -3px 3px #fff, 3px 3px #fff, 3px -3px #fff, 3px -3px #fff, -3px -3px #fff, 3px 3px #fff, -3px -3px #fff ">
        <div class="w-100">
            <h2 class="text-center mb-5" style="font-size: 3.5rem">
                Recent Adtchievements
            </h2>
            <ul class="list-unstyled w-100">
                @foreach ($adtchievements as $adtchievement)
                    <li class="p-3 my-4 shadow-sm w-100 border-rounded rounded bg-light">
                        <div>
                            <strong>
                                {{ $adtchievement->pirate->name }}
                            </strong>
                            earned {{ $adtchievement->points }} points because they
                            {{ $adtchievement->adtchievement->past_tense }}
                            {{ $adtchievement->created_at->diffForHumans() }}
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
