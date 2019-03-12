@extends('admin.layout')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h1 class="section-header">
                        Edit {{ $participant->full_name }}
                    </h1>

                </div>
                <div class="card-body bg-light">
                    {!! Form::model($participant, ['url' => action([\Francken\Association\Symposium\Http\AdminSymposiumParticipantsController::class, 'update'], [$symposium->id, $participant->id]), 'method' => 'put']) !!}

                        @include('admin.association.symposia.participants._form', ['symposium' => $symposium, 'participant' => $participant])

                        {!! Form::submit('Update', ['class' => 'btn btn-outline-success']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
