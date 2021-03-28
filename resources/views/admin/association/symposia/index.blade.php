@extends('admin.layout')
@section('page-title', 'Symposia')

@section('content')
    <div class="card">
        @include('admin.association.symposia._table', ['symposia' => $symposia])

        <div class="card-footer">
            {!! $symposia->links() !!}
        </div>
    </div>
@endsection

@section('actions')
    <div class="d-flex align-items-end">
        <a href="{{ action([\Francken\Association\Symposium\Http\AdminSymposiaController::class, 'create']) }}"
            class="btn btn-primary"
        >
            Start new symposium
        </a>
    </div>
@endsection
