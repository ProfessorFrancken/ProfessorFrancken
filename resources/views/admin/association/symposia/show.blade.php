@extends('admin.layout')
@section('page-title', 'Symposia / ' . $symposium->name)

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
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

                        <div class="col-sm-3">
                            <a href="{{ action([\Francken\Association\Symposium\Http\AdminSymposiaController::class, 'edit'], $symposium->id) }}"
                               class="btn btn-outline-primary"
                            >
                                Edit
                            </a>
                        </div>
                    </dl>


                    <h3>
                        Participants ({{ $symposium->participants->where('is_spam', false)->count() }})
                    </h3>
                </div>

                @include('admin.association.symposia._participants_table', [
                    'participants' => $symposium->participants->where('is_spam', false)
                ])

                <div class="card-body">
                    <h4>
                        Spam
                    </h4>
                </div>
                @include('admin.association.symposia._participants_table', [
                    'participants' => $symposium->participants->where('is_spam', true)
                ])

                <div class="card-body">

                    <a href="{{ action([\Francken\Association\Symposium\Http\AdminSymposiumParticipantsController::class, 'create'], $symposium->id) }}"
                       class="btn btn-outline-primary"
                    >
                        Manually add a participant
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
