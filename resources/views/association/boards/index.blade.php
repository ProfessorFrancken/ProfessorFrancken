@extends('layout.one-column-layout')

@section('main-content')
    <div class="container my-5">
        <h2 class="section-header section-header--centered">
            Boards of T.F.V. 'Professor Francken'
        </h2>
    </div>

    @foreach ($boards as $board)
        @include("association.boards._board", ['board' => $board])
    @endforeach

    @guest
    <div class="container mt-5">
        <x-login-prompt title="Login to view older boards">
        </x-login-prompt>
    </div>
    @endguest
@endsection
