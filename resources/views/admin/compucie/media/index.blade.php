@extends('admin.layout')
@section('page-title', 'Media')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <ul class="row list-unstyled">
                        @foreach ($directories as $directory)
                            <li class="col-md-2 my-3 position-relative">
                                <div class="bg-light shadow-sm p-3 h-100">
                                    <a href="{{ $directory->url() }}"
                                       class="stretched-link d-flex"
                                    >
                                        <i class="fas fa-folder h2"></i>
                                        <div class="ml-3 d-flex flex-column justify-content-center">
                                            <small class="text-monospace">
                                                {{ $directory->name() }}/
                                            </small>
                                        </div>
                                    </a>
                                </div>
                            </li>
                        @endforeach
                        @foreach ($media as $file)
                            <li class="col-md-2 my-3 position-relative">
                                <div class="bg-light rounded-sm shadow-sm p-3 h-100">
                                    <a href="{{ $file->mediaUrl() }}"
                                       class="stretched-link d-flex"
                                       target="_blank"
                                    >
                                        <i class="{{ $file->iconClass() }} h3"></i>
                                        <div class="ml-3 d-flex flex-column justify-content-center">
                                            <small class="text-monospace">
                                                {{ $file->basename }}
                                            </small>
                                            <small class="text-muted">
                                                {{ $file->readableSize(1) }}
                                            </small>
                                        </div>
                                    </a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{ $media->links() }}
            </div>
        </div>
    </div>
@endsection
