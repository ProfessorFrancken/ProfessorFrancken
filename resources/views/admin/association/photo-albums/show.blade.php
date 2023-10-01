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
                                'href' => action(
                                    [\Francken\Association\Photos\Http\Controllers\AdminPhotosController::class, 'edit'],
                                    ['album' => $album, 'photo' => $photo]
                                ),
                                'show_visibility' => true,
                                'is_cover' => $album->cover_photo_id === $photo->id,
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

    {!!
           Form::model(
               $album,
               [
                   'url' => action(
                       [\Francken\Association\Photos\Http\Controllers\AdminPhotoAlbumsController::class, 'destroy'],
                       ['album' => $album]
                   ),
                   'method' => 'post'
               ]
           )
    !!}
    @method('DELETE')
    <p class="mt-2 text-muted d-flex align-items-center justify-content-end">
        Click <button
                  class="btn btn-text px-1"
                  onclick='return confirm("Are you sure you want to remove this album?");'
              >here</button> to remove this album.
    </p>
    {!! Form::close() !!}
@endsection

@section('actions')
    <div class="d-flex align-items-start gap-3">
        <a href="{{ $album->nextcloudUrl()  }}"
            class="btn btn-primary"
        >
            <i class="fa-solid fa-cloud"></i>
            Open in nextcloud
        </a>
        <a href="{{ action([\Francken\Association\Photos\Http\Controllers\AdminPhotoAlbumsController::class, 'edit'], ['album' => $album]) }}"
            class="btn btn-primary"
        >
            <i class="fas fa-edit"></i>
            Edit album
        </a>
        {!! Form::open(['url' => action([\Francken\Association\Photos\Http\Controllers\AdminPhotoAlbumsController::class, 'refreshAlbum'], ['album' => $album])]) !!}
        <button
            class='btn btn-primary'
        >
            <i class="fas fa-sync"></i>
            Refresh
        </button>
        {!! Form::close() !!}
    </div>
@endsection
