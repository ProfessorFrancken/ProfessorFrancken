@extends('admin.layout')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h1 class="section-header">
                        {{ $symposium->name }}
                    </h1>

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
                        Participants
                    </h3>
                </div>

                <table class="table">
                    <thead class="">
                        <tr>
                            <th scope="col">Particpant</th>
                            <th scope="col">NNV</th>
                            <th scope="col">Francken</th>
                            <th scope="col">Has paid</th>
                            <th scope="col" class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($symposium->participants as $participant)
                            <tr>
                                <td>
                                    <h4>
                                        {{ $participant->full_name }}
                                    </h4>
                                    <span>{{ $participant->email }}</span>
                                    @if (is_null($participant->email_verified_at))
                                        (Not yet verified)
                                    @endif
                                </td>
                                <td>
                                    {{ $participant->is_nnv_member ? "Yes" : "No" }}<br />
                                    {{ $participant->nnv_number }}
                                </td>
                                <td>
                                    {{ $participant->is_francken_member ? "Yes" : "No" }}<br />
                                    {{ $participant->member_id }}
                                </td>
                                <td>
                                    {{ $participant->has_paid ? "Yes" : "No" }}<br />
                                </td>
                                <td class="text-right d-flex justify-content-end">
                                    <a class="btn btn-primary btn-sm mr-3" href="{{ action([\Francken\Association\Symposium\Http\AdminSymposiumParticipantsController::class, 'edit'], [$symposium->id, $participant->id]) }}">
                                        Edit
                                    </a>

                                    <form method="POST" action="{{ action([\Francken\Association\Symposium\Http\AdminSymposiumParticipantsController::class, 'remove'], [$symposium->id, $participant->id]) }}">
                                        @csrf
                                        @method("DELETE")

                                        <button class="btn btn-primary btn-sm">
                                            Remove
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

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
