@extends('lustrum.tv.layout')


@section('content')
    <div
        style="
               background-image: url({{ url('uploads/images/lustrum/lustrum-ocean.jpeg') }});
               background-size: cover;

               "
    >
    <div class="d-flex justify-content-between align-items-center p-5" style="height: 100vh; width: 100vw; text-shadow: 3px 0px #fff, -3px 0px #fff, 0px 3px #fff, 0px -3px #fff, 3px 3px #fff, -3px 3px #fff, 3px 3px #fff, 3px -3px #fff, 3px -3px #fff, -3px -3px #fff, 3px 3px #fff, -3px -3px #fff ">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <img src="{{ url('uploads/images/lustrum/bluebeardR-01.png') }}" alt="" class="img-fluid mr-4" width="400"/>
            </div>
            <div class="d-flex flex-column">
                <h1 style="font-size: 4rem;" class="text-left">
                    Blue beards
                </h1>
                <h2 style="font-size: 3rem;" class="text-left">
                    {{ $blue_beards->total_points }}
                </h2>

                @if ($blue_beards->pirate_of_the_day)
                    <span class="mt-4" style="font-size: 2.0rem; font-weight: normal">
                        Pirate of the day
                    </span>

                    <strong class="text-primary">
                        {{ $blue_beards->pirate_of_the_day->name }}
                    </strong>
                @endif
            </div>
        </div>
        <h1 style="font-size: 8rem;">
            VS
        </h1>
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex flex-column text-right">
                <h1 style="font-size: 4rem;" class="text-right">
                    Red beards
                </h1>
                <h2 style="font-size: 3rem;" class="text-right">
                    {{ $red_beards->total_points }}
                </h2>

                @if ($red_beards->pirate_of_the_day)
                    <span class="mt-4" style="font-size: 2.0rem; font-weight: normal">
                        Pirate of the day
                    </span>

                    <strong class="text-primary">
                        {{ $red_beards->pirate_of_the_day->name }}
                    </strong>
                @endif
            </div>
            <div>
                <img src="{{ url('uploads/images/lustrum/redbeardL-01.png') }}" alt="" class="img-fluid ml-4" width="400"/>
            </div>
        </div>
    </div>
@endsection
