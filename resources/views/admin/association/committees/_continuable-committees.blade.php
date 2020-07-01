<div class="card">
    <div class="card-body">
        <h4 class="font-weight-bold">
            Continue committee from a previous year
        </h4>
        <p>
            Use this form to add a committee based on a committee from a previous year.
            This will keep the logo, photo, description etc. from the previous committee so that you don't have to reuplaod all of their settings.
        </p>
        <p>
            The list below shows all of our previous committees, which may be useful as inspiration for starting new committees.
        </p>
        <ul class="list-unstyled" id="continuable-committees">
            @foreach ($continueable_committees as $committee)
                <li class="p-2 my-2 bg-light">
            {!!
               Form::model(
                   $committee,
                   [
                       'url' => action(
                           [\Francken\Association\Committees\Http\AdminContinueCommitteesController::class, 'store'],
                           ['board' => $board]
                       ),
                       'method' => 'post',
                       'class' =>  'd-flex justify-content-between align-items-center'
                   ]
               )
            !!}
                    {!! Form::hidden("committee_id", $committee->id) !!}
                    <a href="{{ action(
                                [\Francken\Association\Committees\Http\AdminCommitteesController::class, 'show'],
                                ['committee' => $committee, 'board' => $committee->board]
                                ) }}"
                       class="d-flex justify-content-start align-items-center"
                    >
                        <img
                            class="rounded mr-2 my-2"
                            src="{{ $committee->logo }}"
                            style="
                                   width: 60px;
                                   max-width: 60px;
                                   max-height: 40px;
                                   object-fit: contain;"
                        />
                        <div class="d-flex flex-column justify-content-between" >
                            <span class="font-weight-bold">
                                {{ $committee->name }}
                            </span>

                            <small class="text-muted">
                                {{ $committee->board->board_name->toString() }}
                            </small>
                        </div>
                    </a>
                    <div class="ml-auto d-flex align-items-center">
                        <button class="btn btn-text text-primary btn-sm" type="submit">
                            {{-- Added for tests.. --}}
                            <small class="text-primary mr-2 d-none">
                                Restart committee
                            </small>
                            <i class="fas fa-plus text-muted"></i>
                        </button>
                    </div>
                    {!!  Form::close() !!}
                </li>
            @endforeach
        </ul>
    </div>
</div>
