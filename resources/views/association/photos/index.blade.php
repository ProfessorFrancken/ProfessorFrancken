@extends('layout.one-column-layout')

@section('title', "Photos - T.F.V. 'Professor Francken'")

@section('content')

    @if (session('private-album-login') === true)
        <div class="alert alert-success font-weight-bold" role="alert">
            You can now view private photos
        </div>
    @endif

    <h1 class="section-header section-header--centered mb-5">
        Photos
    </h1>
    <p>
      Welcome to our fun, lovely and colourful pictures of our experiences in T.F.V. 'Professor Francken', with many beautiful portraits of beautiful people. If at any time you feel camera shy, just let us know at <a href="mailto: Fotociefrancken@gmail.com">Fotociefrancken@gmail.com</a> or let board know at <a href="mailto: board@professorfrancken.nl">board@professorfrancken.nl</a>, and we will make sure those photos disappear into thin air.
  </p>

    <ul class="agenda-list list-unstyled photo-grid">
        @foreach ($albums as $album)
            @include('association.photos._photo', [
                'title' => $album->title,
                'amount_of_photos' => $album->amount_of_photos,
                'views' => $album->views,
                'photo' => $album->coverPhoto ?? $album->photos()->first(),
                'classes' => $loop->first ? ['photo-cover'] : [],
                'href' => $album->url(),
             ])
        @endforeach
    </ul>

    {{ $albums->onEachSide(3)->links() }}

    @if (! $albums->hasMorePages())
        @cannot('view-members-only-albums')
        <div class="card bg-light">
            <div class="card-body">
                <h3 class="h5">Login to view older albums</h3>
                <p>Fill in the <strong>album password</strong> below to view more albums. Don't know the password? Ask a board member.</p>

                @include('association.photos._login-form')
            </div>
        </div>
        @endcannot
    @endif


@endsection
