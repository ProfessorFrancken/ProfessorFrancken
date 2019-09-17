@extends('admin.layout')
@section('page-title', 'Boards / ' . $board->name)

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body bg-light">
                    {!!
                       Form::model($board, [
                           'url' => action([\Francken\Association\Boards\Http\Controllers\AdminBoardsController::class, 'update'], $board->id),
                           'method' => 'PUT',
                           'enctype' => 'multipart/form-data'
                       ])
                    !!}

                        @include('admin.association.boards._form', ['symposium' => $board])

                        {!! Form::submit('Save', ['class' => 'btn btn-outline-success']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
