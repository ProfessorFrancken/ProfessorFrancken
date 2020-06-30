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
            The list below shows all of our previous committees, which may also [act as] inspiration for starting new committees.
        </p>
        <ul class="list-unstyled">
            @foreach ($continueable_committees as $committee)
                <li class="p-2 my-2 bg-light d-flex justify-content-between align-items-center">
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
                        <button class="btn btn-text text-primary btn-sm">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
