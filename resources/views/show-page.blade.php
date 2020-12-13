@extends('layout.one-column-layout')
@section('title', $page->title . " - T.F.V.'Professor Francken'")

@section('content')
    <div>
        {!!
               $page->compiled_content
        !!}
    </div>
    <p class="mt-4 pt-4 border-top text-center text-muted">
        <small>
        Last updated: {{ $page->updated_at->diffForHumans() }}
        @can('dashboard:pages-write')
        <a href="{{ action([\Francken\Shared\Http\Controllers\Admin\PagesController::class, 'edit'], ['page' => $page]) }}"
           class="btn btn-text text-primary btn-sm ml-0"
        >
            (
            <i class="fas fa-edit"></i> Edit
            )
        </a>
        @endcan
        </small>
    </p>
@endsection
