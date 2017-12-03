@extends('my-francken.index')

@section('content')
    <h2 class="section-header">
        <i class="fa fa-user text-primary text-center" aria-hidden="true"></i>
        Hi, {{ $profile->voornaam }}
    </h2>

    @include('my-francken.profile._personal')
    @include('my-francken.profile._bank')
    @include('my-francken.profile._study')
    @include('my-francken.profile._career')
    @include('my-francken.profile._settings')

@endsection
