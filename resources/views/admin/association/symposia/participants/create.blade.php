@extends('admin.layout')
@section('page-title', $symposium->name . ' / Add participant')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body bg-light">
                    {!! Form::model($participant, ['url' => action([\Francken\Association\Symposium\Http\AdminSymposiumParticipantsController::class, 'store'], $symposium->id), 'method' => 'post']) !!}

                        @include('admin.association.symposia.participants._form', ['symposium' => $symposium, 'participant' => $participant])

                        {!! Form::submit('Add participant', ['class' => 'btn btn-outline-success']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
