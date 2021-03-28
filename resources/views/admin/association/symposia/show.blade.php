@extends('admin.layout')
@section('page-title', 'Symposia / ' . $symposium->name)

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-2">
                        <img
                            class="img-fluid"
                            alt="{{ $symposium->name }} logo"
                            src="{{ $symposium->logo }}"
                        />
                        </div>
                        <div class="col">

                    <dl class="row">
                        <dt class="col-sm-3">Schedule</dt>
                        <dd class="col-sm-9">
                            From
                            {{ $symposium->start_date->format('Y-m-d H:i') }}
                            to
                            {{ $symposium->end_date->format('H:i') }}
                        </dd>

                        <dt class="col-sm-3">Location</dt>
                        <dd class="col-sm-9">{{ $symposium->location }}</dd>

                        <dt class="col-sm-3">Google maps url</dt>
                        <dd class="col-sm-9">
                            <a href="{{ $symposium->location_google_maps_url }}">{{ $symposium->location_google_maps_url }}</a>
                        </dd>

                        <dt class="col-sm-3">Website url</dt>
                        <dd class="col-sm-9">
                            <a href="{{ $symposium->website_url }}">
                                {{ $symposium->website_url }}
                            </a>
                        </dd>

                        <dt class="col-sm-3">Open for registration</dt>
                        <dd class="col-sm-9">{{ $symposium->open_for_registration ? 'Yes' : 'No' }}</dd>

                        <dt class="col-sm-3">Promote on agenda</dt>
                        <dd class="col-sm-9">{{ $symposium->promote_on_agenda ? 'Yes' : 'No' }}</dd>


                    </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card my-3">
                <div class="card-header">
                    <h3>
                        Participants ({{ $symposium->participants->where('is_spam', false)->count() }})
                    </h3>
                </div>

                @include('admin.association.symposia._participants_table', [
                    'participants' => $symposium->participants->where('is_spam', false)
                ])

                @if ($show_spam)
                    <div class="card-body">
                        <h4>
                            Spam
                        </h4>
                    </div>
                    @include('admin.association.symposia._participants_table', [
                                    'participants' => $symposium->participants->where('is_spam', true)
                    ])
                @endif

                <div class="card-footer">

                    <a href="{{ action([\Francken\Association\Symposium\Http\AdminSymposiumParticipantsController::class, 'create'], $symposium->id) }}"
                       class="btn btn-outline-primary"
                    >
                        <i class="fas fa-plus"></i>
                        Register a participant
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('actions')
    <div class="d-flex align-items-start">
        <a href="{{ action([\Francken\Association\Symposium\Http\AttendanceController::class, 'index'], $symposium->id) }}"
            class="btn btn-primary"
        >
            <i class="fas fa-clipboard-list"></i>
            Attendance list
        </a>
        <a href="{{ action([\Francken\Association\Symposium\Http\NameTagsController::class, 'index'], $symposium->id) }}"
            class="btn btn-primary mx-2"
        >
            <i class="fas fa-user-tag"></i>
            Name tags
        </a>

        <a href="{{ action([\Francken\Association\Symposium\Http\ExportController::class, 'index'], $symposium->id) }}"
            class="btn btn-primary mx-2"
        >
            <i class="fas fa-file-export"></i>
            Export
        </a>
        <a href="{{ action([\Francken\Association\Symposium\Http\AdminSymposiaController::class, 'edit'], $symposium->id) }}"
            class="btn btn-primary mx-2"
        >
            <i class="far fa-edit"></i>
            Edit
        </a>
    </div>
@endsection
