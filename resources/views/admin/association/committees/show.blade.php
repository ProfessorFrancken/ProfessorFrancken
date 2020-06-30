@extends('admin.layout')
@section('page-title', 'Committees / ' . $committee->name)

@section('content')
    <div class="row">
        <div class="col-9">
            <div class="card">
                <div class="card-body">
                    <p>
                        Hoi
                    </p>
                    <pre>

- Committee logo
- Committee photo image
- Members
- Board year
- Activities
- Photo albums

* Committee

- id
- name
- slug
- board_id
- parent_committee (nullable)
- logo
- photo (nullable)
- page_contents (nullable)
- email (nullable)
- members
- installed at
- decharged at
- is_public
                    </pre>
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
            @include('admin.association.committees.members._index', ['committee' => $committee])
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
           class="btn btn-text text-muted mr-3 d-flex justify-content-center align-items-center"
        >
            <div class="mr-2">
                <i class="fas fa-eye"></i>
            </div>
            {{ $committee->parentCommittee->board->board_name->toString() }}
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
