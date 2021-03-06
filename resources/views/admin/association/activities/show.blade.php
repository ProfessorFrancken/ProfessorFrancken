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

            @include('admin.association.activities.sign-up-settings.index', ['activity' => $activity])
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

        <div class="card mb-4">
            <div class="card-body">
                <h4 class="font-weight-bold">
                    <i class="fas fa-qrcode"></i>
                    QR Code
                </h4>

                <p>
                    This QR code sends people to the public activity page. Use it for posters and such.
                </p>

                <div class="text-center">
                    <img
                        class="my-3"
                        src="data:image/png;base64, {!! $qrCode !!} "
                    />
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('actions')
    <div class="d-flex align-items-start">
        <a href="{{ action(
                        [\Francken\Association\Activities\Http\ActivitiesController::class, 'show'],
                        ['activity' => $activity]
                        ) }}"
            class="btn btn-primary mr-2"
        >
            <i class="fas fa-eye"></i>
            Show activity page
        </a>
        <a href="{{ action(
                        [\Francken\Association\Activities\Http\AdminActivitySignUpsExportController::class, 'index'],
                        ['activity' => $activity]
                        ) }}"
            class="btn btn-primary mx-2"
        >
            <i class="fas fa-file-export"></i>
            Export
        </a>
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
