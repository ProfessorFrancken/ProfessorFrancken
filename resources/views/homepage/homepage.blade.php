@extends('homepage.layout')

@section('main-content')
    @include("homepage._about-francken")

    @include("homepage._news")

    @include("homepage._pillars")
@endsection

@section('header-image')
    @include("homepage.header._registration-cta")
@endsection
