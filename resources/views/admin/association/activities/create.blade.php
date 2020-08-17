@extends('admin.layout')
@section('page-title', 'Activities / Create')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    {!!
                       Form::model($activity, [
                           'url' => action(
                               [\Francken\Association\Activities\Http\AdminActivitiesController::class, 'store'] ,
                               ['activity' => $activity]
                           ),
                       ])
                    !!}
                        @include('admin.association.activities._form', ['committee' => $activity])

                        <x-forms.submit>Plan activity</x-forms.submit>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
