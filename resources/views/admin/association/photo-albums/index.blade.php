@extends('admin.layout')
@section('page-title', 'Photo albums')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <ul class="agenda-list list-unstyled photo-grid">
                        @foreach ($albums as $album)
                            @include('admin.association.photo-albums._photo', [
                                'title' => $album->title,
                                'amount_of_photos' => $album->photos_count,
                                'photo' => $album->coverPhoto ?? $album->photos()->first(),
                                'classes' =>  ['shadow m-2 border'],
                                'href' => action([\Francken\Association\Photos\Http\Controllers\AdminPhotoAlbumsController::class, 'show'], ['album' => $album]),
                            ])
                        @endforeach
                    </ul>
                </div>
                @if($albums->hasMorePages())
                    <div class="card-footer">
                        {!! $albums->links() !!}
                    </div>
                @endif
            </div>
            <div class="card">
                <div class="card-body">
                    <ul class="agenda-list list-unstyled photo-grid">
                        @foreach ($flickrAlbums as $album)
                            @include('association.photos._photo', [
                                'title' => $album->title,
                                'amount_of_photos' => $album->amount_of_photos,
                                'views' => $album->views,
                                'photo' => $album->coverPhoto ?? $album->photos()->first(),
                                'classes' =>  ['shadow m-2 border'],
                                'href' => $album->url(),
                            ])
                        @endforeach
                    </ul>
                </div>

                @if($flickrAlbums->hasMorePages())
                    <div class="card-footer">
                        {!! $flickrAlbums->links() !!}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('actions')
    <div class="d-flex align-items-start gap-3">
        <a href="{{ action([\Francken\Association\Photos\Http\Controllers\AdminPhotoAlbumsController::class, 'create']) }}"
            class="btn btn-primary"
        >
            <i class="fas fa-plus"></i>
            Create album
        </a>
        {!! Form::open(['url' => action([\Francken\Association\Photos\Http\Controllers\AdminPhotoAlbumsController::class, 'refresh'])]) !!}
        <button
           class='btn btn-primary'
        >
            <i class="fas fa-sync"></i>
            Refresh
        </button>
        {!! Form::close() !!}
    </div>
@endsection

