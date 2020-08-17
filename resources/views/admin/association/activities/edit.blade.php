@extends('admin.layout')
@section('page-title', 'Activities / ' . $activity->name . ' / Edit')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    {!!
                       Form::model($activity, [
                           'url' => action(
                               [\Francken\Association\Activities\Http\AdminActivitiesController::class, 'update'] ,
                               ['activity' => $activity]
                           ),
                           'method' => 'PUT',
                       ])
                    !!}
                        @include('admin.association.activities._form', ['committee' => $activity])

                        <x-forms.submit>Save</x-forms.submit>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
