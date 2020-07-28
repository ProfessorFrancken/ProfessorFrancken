@extends('admin.layout')
@section('page-title', 'Photo albums')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <ul class="agenda-list list-unstyled photo-grid">
                        @foreach ($albums as $album)
                            @include('association.photos._photo', [
                                'title' => $album->title,
                                'amount_of_photos' => $album->amount_of_photos,
                                'views' => $album->views,
                                'photo' => $album->coverPhoto,
                                'classes' =>  ['shadow m-2 border'],
                                'href' => $album->url(),
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
        </div>
    </div>
@endsection

@section('actions')
    <div class="d-flex align-items-start">
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
