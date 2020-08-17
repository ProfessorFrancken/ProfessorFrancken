@extends('admin.layout')
@section('page-title', 'Activities / ' . $activity->name . '/ Add sign up settings')

@section('content')
    <div class="card">
        <div class="card-body">
            {!!
                   Form::model($activity, [
                       'url' => action(
                           [\Francken\Association\Activities\Http\AdminSignUpSettingsController::class, 'store'] ,
                           ['activity' => $activity]
                       ),
                   ])
            !!}
                @include('admin.association.activities.sign-up-settings._form', ['committee' => $activity])

                <x-forms.submit>Add sign up settings</x-forms.submit>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
