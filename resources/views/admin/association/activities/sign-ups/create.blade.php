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
            @include('admin.association.activities.sign-ups._form', ['activity' => $activity])

                <x-forms.submit>Sign up</x-forms.submit>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
