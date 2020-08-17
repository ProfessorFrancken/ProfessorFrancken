@extends('admin.layout')
@section('page-title', 'Activities / ' . $activity->name . ' / ' . $signUp->member->full_name . '/ Edit sign up')

@section('content')
    <div class="card">
        <div class="card-body">
            {!!
                   Form::model($signUp, [
                       'url' => action(
                           [\Francken\Association\Activities\Http\AdminSignUpsController::class, 'update'] ,
                           ['activity' => $activity, 'sign_up' => $signUp]
                       ),
                       'method' => 'PUT',
                   ])
            !!}
            @include('admin.association.activities.sign-ups._form', ['committee' => $activity])

                <x-forms.submit>Save sign up</x-forms.submit>
            {!! Form::close() !!}
        </div>
    </div>

        {!!
               Form::model(
                   $activity,
                   [
                       'url' => action(
                           [\Francken\Association\Activities\Http\AdminSignUpsController::class, 'destroy'] ,
                           ['activity' => $activity, 'sign_up' => $signUp]
                       ),
                       'method' => 'post'
                   ]
               )
        !!}
        @method('DELETE')
        <p class="mt-2 text-muted d-flex align-items-center justify-content-end">
            Click <button
                      class="btn btn-text px-1"
                      onclick='return confirm("Are you sure you want to remove sign up?");'
                  >here</button> to remove sign up.
        </p>
        {!! Form::close() !!}
@endsection
