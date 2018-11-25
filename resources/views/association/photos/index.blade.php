@extends('layout.one-column-layout')

@section('title', "Photos - T.F.V. 'Professor Francken'")

@section('content')
    <h1 class="section-header section-header--centered mb-5">
        Photos
    </h1>

    <ul class="agenda-list list-unstyled photo-grid">
        @foreach ($albums as $album)
            @include('association.photos._photo', [
                'title' => $album->title,
                'amount_of_photos' => $album->amount_of_photos,
                'views' => $album->views,
                'photo' => $album->coverPhoto,
                'classes' => $loop->first ? ['photo-cover'] : [],
                'href' => $album->url(),
             ])
        @endforeach
    </ul>

    {{ $albums->onEachSide(3)->links() }}
@endsection
