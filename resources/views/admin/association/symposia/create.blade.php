@extends('admin.layout')
@section('page-title', 'Symposia / create')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body bg-light">
                    {!! Form::model($symposium, ['url' => action([\Francken\Association\Symposium\Http\AdminSymposiaController::class, 'store']), 'method' => 'post']) !!}

                        @include('admin.association.symposia._form', ['symposium' => $symposium])

                        {!! Form::submit('Add symposium', ['class' => 'btn btn-outline-success']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
