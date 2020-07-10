<div class="card">
    <div class="card-body">
        <h5 class="font-weight-bold">
            <i class="fas fa-user-friends"></i>
            Suggested committee members
        </h5>

    <ul class="list-unstyled">

    @foreach ($committee->suggestedCommitteeMembers as $member)
        <li class="p-2 my-2 bg-light">
            {!!
               Form::model(
                   $member,
                   [
                       'url' => action(
                           [\Francken\Association\Committees\Http\AdminCommitteeMembersController::class, 'store'],
                           ['board' => $committee->board, 'committee' => $committee]
                       ),
                       'method' => 'post',
                       'class' =>  'd-flex justify-content-between align-items-center'
                   ]
               )
            !!}
            {!! Form::hidden("member_id", $member->member_id) !!}
            {!! Form::hidden("committee_id", $member->committee_id) !!}
            {!! Form::hidden("function", $member->function) !!}
            {!! Form::hidden("installed_at", $committee->board->installed_at->format('Y-m-d')) !!}
            <div class="d-flex flex-column justify-content-between" >
                <span class="font-weight-bold">
                    {{ $member->member->fullname }}
                </span>

                <small class="text-muted">
                    {{ $member->function }}
                </small>
            </div>
            <div class="ml-auto d-flex align-items-center">
                @if ($member->decharged_at !== null)
                    <small class="text-muted">
                        decharged {{ $member->decharged_at->diffForHumans() }}
                    </small>
                @endif
                <button
                    class="btn btn-text text-primary btn-sm"
                    type="submit"
                >
                    <span class="d-none">
                        Reinstall
                    </span>
                    <i class="fas fa-plus text-muted ml-2"></i>
                </button>
            </div>
            {!! Form::close() !!}
        </li>
    @endforeach

    </ul>
    </div>

</div>
