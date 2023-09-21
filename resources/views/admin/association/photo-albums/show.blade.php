@extends('admin.layout')
@section('page-title', 'Photo albums / ' . $album->published_at->format('Y-m-d') . ' / ' . $album->title)

@section('content')
    <p class="d-flex gap-3 align-items-center">
        <span>
            <i class="fas fa-eye"></i>
            {{ $album->visibility }}
        </span>
        <span>
            <code>
                {{ $album->path }}
            </code>
        </span>
    </p>
    <p class="lead">
        {{ $album->description  }}
    </p>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">

                    <ul class="agenda-list list-unstyled photo-grid">
                        @foreach ($photos as $photo)
                            @include('admin.association.photo-albums._photo', [
                                'photo' => $photo,
                                'title' => $photo->name,
                                'href' => '#',
                                'show_visibility' => true,
                            ])
                        @endforeach
                    </ul>
                </div>

                @if($photos->hasMorePages())
                    <div class="card-footer">
                        {!! $photos->links() !!}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('actions')
    <div class="d-flex align-items-start gap-3">
        <a href="{{ action([\Francken\Association\Photos\Http\Controllers\AdminPhotoAlbumsController::class, 'edit'], ['album' => $album]) }}"
            class="btn btn-primary"
        >
            <i class="fas fa-edit"></i>
            Edit album
        </a>
    </div>
@endsection
