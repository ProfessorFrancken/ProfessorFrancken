@extends('admin.layout')
@section('page-title', 'Activities / ' . $activity->name . '/ Edit sign up settings')

@section('content')
    <div class="card">
        <div class="card-body">
            {!!
                   Form::model($signUpSettings, [
                       'url' => action(
                           [\Francken\Association\Activities\Http\AdminSignUpSettingsController::class, 'update'] ,
                           ['activity' => $activity]
                       ),
                       'method' => 'PUT',
                   ])
            !!}
            @include('admin.association.activities.sign-up-settings._form', ['committee' => $activity])

            {!! Form::submit('Save sign up settings', ['class' => 'btn btn-outline-success']) !!}
            {!! Form::close() !!}
        </div>
    </div>

        {!!
               Form::model(
                   $activity,
                   [
                       'url' => action(
                           [\Francken\Association\Activities\Http\AdminSignUpSettingsController::class, 'destroy'] ,
                           ['activity' => $activity]
                       ),
                       'method' => 'post'
                   ]
               )
        !!}
        @method('DELETE')
        <p class="mt-2 text-muted d-flex align-items-center justify-content-end">
            Click <button
                      class="btn btn-text px-1"
                      onclick='return confirm("Are you sure you want to remove sign up settings?");'
                  >here</button> to remove sign up settings.
        </p>
        {!! Form::close() !!}
@endsection
