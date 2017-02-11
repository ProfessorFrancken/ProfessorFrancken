@extends('homepage.layout')

@section('content')
    <header>
        <div class="row no-gutters">
            <div class="col-6 col-md-4 text-right">
                @include("homepage.logo")
            </div>
            <div class="col">
                @include("homepage.navigation")
            </div>
        </div>

        @include("homepage.registration-cta")
    </header>

    @include("homepage.about-francken")

    @include("homepage.news")

    @include("homepage.pillars")

    @include("homepage.footer")
@endsection
