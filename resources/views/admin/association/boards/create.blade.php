@extends('admin.layout')
@section('page-title', 'Boards / Install a new board')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body bg-light">
                    {!!
                       Form::model($board, [
                           'url' => action([\Francken\Association\Boards\Http\Controllers\AdminBoardsController::class, 'store']),
                           'method' => 'POST',
                           'enctype' => 'multipart/form-data'
                       ])
                    !!}
                        @include('admin.association.boards._form', ['board' => $board])

                        <x-forms.submit>Install</x-forms.submit>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
