@extends('homepage.one-column-layout')
@inject('boards', "Francken\Domain\Boards\BoardRepository")

@section('main-content')
    <div class="contaienr my-5">
        <h2 class="section-header section-header--centered">
            Boards of T.F.V. 'Professor Francken'
        </h2>
    </div>

    @foreach ($boards->all() as $board)
        @include("pages.association._board", ['board' => $board])
    @endforeach

@endsection
