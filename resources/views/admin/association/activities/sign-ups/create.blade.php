@extends('admin.layout')
@section('page-title', 'Activities / ' . $activity->name . '/ Add sign up')

@section('content')
    <div class="card">
        <div class="card-body">
            {!!
                   Form::model($activity, [
                       'url' => action(
                           [\Francken\Association\Activities\Http\AdminSignUpsController::class, 'store'] ,
                           ['activity' => $activity]
                       ),
                   ])
            !!}
            @include('admin.association.activities.sign-ups._form', ['committee' => $activity])

            {!! Form::submit('Sign up', ['class' => 'btn btn-outline-success']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection
