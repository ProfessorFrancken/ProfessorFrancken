@extends('admin.layout')
@section('page-title', 'Committees / ' . $board->board_name->toString() . ' / Start a new committee')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body bg-light">
                    {!!
                       Form::model($committee, [
                           'url' => action(
                               [\Francken\Association\Committees\Http\AdminCommitteesController::class, 'store'],
                               ['board' => $board]
                           ),
                           'method' => 'POST',
                           'enctype' => 'multipart/form-data'
                       ])
                    !!}
                        @include('admin.association.committees._form', ['committee' => $committee])

                        {!! Form::submit('Start committee', ['class' => 'btn btn-outline-success']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
