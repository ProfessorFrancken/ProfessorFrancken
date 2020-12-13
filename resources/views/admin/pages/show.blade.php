@extends('admin.layout')
@section('page-title', 'Pages / ' . $page->title)

@section('content')
    <p class="mt-0">
        Last updated: {{ $page->updated_at->diffForHumans() }}
    </p>
    <div class="card">
        <div class="card-body">
        {!!
               $page->compiled_content
        !!}
        </div>
    </div>
@endsection

@section('actions')
    <div class="d-flex align-items-start">
        <a href="{{ action([\Francken\Shared\Http\Controllers\Admin\PagesController::class, 'edit'], ['page' => $page]) }}"
           class="btn btn-primary btn-sm"
        >
            <i class="fas fa-edit"></i>
            Edit
        </a>
    </div>
@endsection
