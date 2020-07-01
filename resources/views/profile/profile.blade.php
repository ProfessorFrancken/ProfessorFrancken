@extends('layout.two-column-layout')

@section('content')

    <h2 class="section-header">
        Hoi {{ $member->fullName()  }}
    </h2>

    <p class="lead">
        Welcom to your francken profile page.
    </p>

    @include('profile.profile._personal')
    @include('profile.profile._bank')
    @include('profile.profile._study')
    @include('profile.profile._career')
    @include('profile.profile._settings')

    <h3>Your committees</h3>
    <ul>
        @foreach ($committees as $committee)
            <li>{{ $committee->name  }} ({{ $committee->board->board_name->toString() }})</li>
        @endforeach
    </ul>
@endsection

@section('aside')
    @include('profile._sidebar', ['member' => $member])
@endsection

@section('header-image')
    @component('layout.header._header_image')
    <div class="header-image__title">

    </div>
    @endcomponent
@endsection
