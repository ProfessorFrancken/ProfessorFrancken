@extends('admin.layout')
@section('page-title', 'Symposia / ' . $symposium->name)

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">

                </div>
                <div class="card-body bg-light">
                    {!! Form::model($symposium, ['url' => action([\Francken\Association\Symposium\Http\AdminSymposiaController::class, 'update'], $symposium->id), 'method' => 'put']) !!}

                        @include('admin.association.symposia._form', ['symposium' => $symposium])

                        {!! Form::submit('Save', ['class' => 'btn btn-outline-success']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
