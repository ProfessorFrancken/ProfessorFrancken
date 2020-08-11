@extends('admin.layout')
@section('page-title', 'Committees / ' . $committee->board->board_name->toString() . ' / ' . $committee->name)

@section('content')
    <div class="row">
        <div class="col-9">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-start">
                        <img
                            class="rounded m-3 mr-4"
                            src="{{ $committee->logo }}"
                            alt="Logo of {{ $committee->name }}"
                            style="
                                   max-width: 300px;
                                   max-height: 160px;
                                   object-fit: contain;"
                        />
                        <div class="">
                            @if ($committee->email)
                                <p class="mb-1">
                                    <a href="mailto:{{ $committee->email }}">
                                        {{ $committee->email }}
                                    </a>
                                </p>
                            @endif
                            @if ($committee->goal)
                                <p class="my-1">
                                    {{ $committee->goal }}
                                </p>
                            @endif
                            <div>
                                @if ($committee->is_public)
                                    <p class="my-1">
                                        <i class="far fa-check-square"></i>
                                        This committe is shown on the <a href={{ action(
                                                                                 [\Francken\Association\Committees\Http\CommitteesController::class, 'show'],
                                                                                 ['committee' => $committee, 'board' => $committee->board]
                                                                                 ) }}>
                                            committees page
                                        </a>.
                                    </p>
                                @else
                                    <i class="far fa-square"></i>
                                    This committe is not shown on the <a href={{ action(
                                                                                 [\Francken\Association\Committees\Http\CommitteesController::class, 'index'],
                                                                                 ['board' => $committee->board]
                                                                                 ) }}>
                                        committees page
                                    </a>.
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class='p-3 bg-light my-3'>
                        <h5 class="h6">
                            Page content
                        </h5>
                        <div
                            style="max-height: 330px; height: 330px; overflow: auto;"
                        >
                            @if ($committee->compiled_content)
                                {!! $committee->compiled_content !!}
                            @else
                                <div class="d-flex justify-content-center align-items-center" >
                                    <h5 class="text-muted font-weight-light">
                                        Edit this committee's page content with a useful description
                                    </h5>
                                </div>
                            @endif
                        </div>
                    </div>

                    @include('admin.association.committees.members._index', ['committee' => $committee])
                </div>
            </div>
            {!!
               Form::model(
                   $committee,
                   [
                       'url' => action(
                           [\Francken\Association\Committees\Http\AdminCommitteesController::class, 'destroy'],
                           ['committee' => $committee, 'board' => $committee->board]
                       ),
                       'method' => 'post'
                   ]
               )
            !!}
            @method('DELETE')
            <p class="mt-2 text-muted d-flex align-items-center justify-content-end">
                Click <button
                          class="btn btn-text px-1"
                          onclick='return confirm("Are you sure you want to remove this committee?");'
                      >here</button> to remove this committee.
            </p>
            {!! Form::close() !!}
        </div>
        <div class="col-3">
            @include('admin.association.committees.members._suggestions', ['committee' => $committee])
            @include('admin.association.committees.permissions._index', ['committee' => $committee])
        </div>
    </div>
@endsection

@section('actions')
    <div class="d-flex align-items-end">
        @if ($committee->parentCommittee)
        <a href="{{ action(
                    [\Francken\Association\Committees\Http\AdminCommitteesController::class, 'show'],
                    ['committee' => $committee->parentCommittee, 'board' => $committee->parentCommittee->board]
                    ) }}"
           class="btn btn-text text-muted d-flex justify-content-center align-items-center"
           title="View this committee from the previous board"
        >
            <div class="mr-2">
                <i class="fas fa-eye"></i>
            </div>
            {{ $committee->parentCommittee->board->board_name->toString() }}
        </a>
        @endif
        @if ($committee->is_public)
            <a href="{{ action(
                       [\Francken\Association\Committees\Http\CommitteesController::class, 'show'],
                       ['committee' => $committee, 'board' => $committee->board]
                       ) }}"
               class="btn btn-primary mx-3"
            >
                <i class="fas fa-eye"></i>
                View committee page
            </a>
        @endif
        <a href="{{ action(
                    [\Francken\Association\Committees\Http\AdminCommitteesController::class, 'edit'],
                    ['committee' => $committee, 'board' => $committee->board]
                    ) }}"
           class="btn btn-primary"
        >
            <i class="fas fa-edit"></i>
            Edit
        </a>
    </div>
@endsection
