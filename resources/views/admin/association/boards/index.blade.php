@extends('admin.layout')
@section('page-title', 'Boards')

@section('content')
    <div class="card">
        <div class="card-body">
            <ul class="list-unstyled">
                @forelse ($boards as $board)
                    @include('admin.association.boards._board-list-item', ['board' => $board])
                @empty
                    @include('admin.association.boards._boards-import-form')
                @endforelse
            </ul>
        </div>
    </div>
@endsection

@section('actions')
    <div class="d-flex align-items-end">
        @can('export-boards')
        @if ($boards->count() > 0)
            <a href="{{ action([\Francken\Association\Boards\Http\Controllers\AdminExportsController::class, 'export']) }}"
               class="btn btn-primary mr-3"
            >
                <i class="fas fa-cloud-download-alt"></i>
                Export
            </a>
        @endif
        @endcan
        <a href="{{ action([\Francken\Association\Boards\Http\Controllers\AdminBoardsController::class, 'create']) }}"
           class="btn btn-primary"
        >
            <i class="fas fa-plus"></i>
            Install a new board
        </a>
    </div>
@endsection
