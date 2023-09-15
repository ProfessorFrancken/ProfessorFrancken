@extends('admin.layout')
@section('page-title', 'Import album')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <x-forms.select name='album' label="Album path"  :options="$albumDirectories" />

                    <ul class="agenda-list list-unstyled photo-grid">
                        @foreach ($photos as $photo)
                            <img
                                src="{{ action([\Francken\Association\Photos\Http\Controllers\PhotosController::class, 'showImage'], ['path' => $photo]) }}"
                                class="w-100 h-100 rounded photo-img"
                            >
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
