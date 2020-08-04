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

                        {!! Form::submit('Plan activity', ['class' => 'btn btn-outline-success']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
