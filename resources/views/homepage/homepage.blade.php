@extends('homepage.layout')

@section('content')
    <header>
        <div class="row no-gutters">
            <div class="col-6 col-md-4 text-right">
                @include("homepage._logo")
            </div>
            <div class="col">
                @include("homepage._navigation")
            </div>
        </div>

        @include("homepage._registration-cta")
    </header>

    @include("homepage._about-francken")

    @include("homepage._news")

    @include("homepage._pillars")

    @include("homepage._footer")
@endsection
