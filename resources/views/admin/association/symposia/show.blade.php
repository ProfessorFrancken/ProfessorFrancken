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
                        <div class="col">
                            <h6>Registration link</h6>
                            <p>
                                To register a new participant for this symposium use the link shown below:
                            </p>
                            <pre><code>{{  action([Francken\Association\Symposium\Http\ParticipantRegistrationController::class, 'store'], ['symposium' => $symposium]) }}</code></pre>

                            <p>
                                
                            The form may contain the following names inputs:
                                <code>firstname</code>,
    <code>lastname</code>,
    <code>email</code>,
    <code>is_francken_member</code>,
    <code>is_nnv_member</code>,
    <code>nnv_number</code>,
    <code>payment_method</code> (either <code>debit</code> or <code>cash</code>),
    <code>iban</code>,
    <code>free_lunch</code> and
    <code>free_borrelbox</code>.
                            </p>

                            


                            <h6>Email previews</h6>
                            <p>
                                Use the previews below to see the emails we send to participants
                            </p>
                            <ul>
                                <li>
                                    <a href="{{ action(
                                                    [\Francken\Association\Symposium\Http\AdminSymposiaMailPreviewController::class, 'verify'],
                                                    ['symposium' => $symposium]
                                                    )
                                             }}"
                                    >
                                        Verify email 
                                    </a> (send automatically after registering)
                                </li>
                                <li>
                                    <a href="{{ action(
                                                    [\Francken\Association\Symposium\Http\AdminSymposiaMailPreviewController::class, 'information'],
                                                    ['symposium' => $symposium]
                                                    )
                                             }}"
                                    >
                                        Information email
                                    </a> (WIP - can be send manually)
                                </li>
                                <li>
                                    <a href="{{ action(
                                                    [\Francken\Association\Symposium\Http\AdminSymposiaMailPreviewController::class, 'notifyCommittee'],
                                                    ['symposium' => $symposium]
                                                    )
                                             }}"
                                    >
                                        Preview notify committee mail 
                                    </a> (send to committee to inform them of new participant)
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card my-3">
                <div class="card-header">
                    <h3>
                        Participants 
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
