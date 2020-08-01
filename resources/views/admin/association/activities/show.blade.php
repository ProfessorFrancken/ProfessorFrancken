@extends('admin.layout')
@section('page-title', 'Activities / ' . $activity->name)

@section('content')
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <p>
                    <i class="fas fa-clock"></i>
                    {{ $activity->start_date->format("d F H:i") }}
                    to
                    {{ $activity->end_date->format("d F H:i") }}
                </p>

                <div>
                    {!! $activity->compiled_content !!}
                </div>
            </div>

            @include('admin.association.activities._sign_ups', ['activity' => $activity])
        </div>

        {!!
               Form::model(
                   $activity,
                   [
                       'url' => action(
                           [\Francken\Association\Activities\Http\AdminActivitiesController::class, 'destroy'],
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
                      onclick='return confirm("Are you sure you want to remove this activity?");'
                  >here</button> to remove this activity.
        </p>
        {!! Form::close() !!}
    </div>

    <div class="col-3">
        {{--
        @include('admin.association.activities._notes', ['activity' => $activity])
        @include('admin.association.activities._organizers', ['activity' => $activity])
        @include('admin.association.activities._news', ['activity' => $activity])
        @include('admin.association.activities._photo_album', ['activity' => $activity])
        --}}
        @include('admin.association.activities._location', ['activity' => $activity])
    </div>
</div>
@endsection

@section('actions')
    <div class="d-flex align-items-start">
        <a href="{{ action(
                        [\Francken\Association\Activities\Http\AdminActivitiesController::class, 'edit'],
                        ['activity' => $activity]
                        ) }}"
            class="btn btn-primary"
        >
            <i class="fas fa-edit"></i>
            Edit
        </a>
    </div>
@endsection
