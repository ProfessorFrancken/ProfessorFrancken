@extends('pages.association')
@section('header-image-url', '/images/header/library-books.jpeg')
@section('main-content')

<div class="container">
    <h1 class="section-header section-header--centered">
        Francken Vrij
    </h1>

    <div class="row">
        <div class="col-md-12">
            <p>
                Francken Vrij is the popular science magazine of the Technisch Fysische Vereniging ‘Professor Francken’ and is distributed to its members, sponsors and other interested parties. The complete Francken Vrij archive can be found on this page and is available to members only.
            </p>
            <p>
                The theme of each edition is different but relates to (Applied) Physics. The contents of the magazine changes slightly from edition to edition but generally one might expect an article by one of the applied physics research groups, an article by a student about their internship or a graduate about their new job.
                Most editions come with a challenging puzzle and a fun comic as well.
            </p>
        </div>
    </div>
</div>

@guest
<div class="container my-5">
    <x-login-prompt title="Login to view the Francken Vrij" :redirect-to="request()->getRequestUri()">
        <p>
            The Francken Vrij archive is only available to members. Please login to read and download our magazines.
        </p>
    </x-login-prompt>
</div>
@endguest

@auth
<div class="ribbon ribbon--light my-5">
    <div class="container">
        <h2 class="ribbon__header">
            The latest volume
        </h2>

        <div class="ribbon__items row align-items-stretch">
          @foreach($latestEditions as $edition)
              <article class="col-md-4 d-flex flex-column news-item">

                  <h4 class="news-item__title text-center">
                      {{ $edition->title() }}
                  </h4>
                  <div class="text-center">
                      <a href="{{ action([\Francken\Association\FranckenVrij\Http\FranckenVrijPdfController::class, 'show'], ['edition' => $edition]) }}">
                          <img src="{{ $edition->cover() }}" class="img-responsive center-block">
                      </a>
                  </div>

                  <div class="text-center my-3">
                      <a href="{{ action([\Francken\Association\FranckenVrij\Http\FranckenVrijPdfController::class, 'show'], ['edition' => $edition]) }}" class="btn btn-inverse">Download</a>
                  </div>
              </article>
          @endforeach
        </div>
    </div>
</div>

<div class="container my-3">
  @foreach($volumes as $volume)
      <h2>Volume {{ $volume->volume() }}</h2>

      <div class="row">
          @foreach($volume->editions() as $edition)
              <div class="col-sm-4 text-center">
                  <a href="{{ action([\Francken\Association\FranckenVrij\Http\FranckenVrijPdfController::class, 'show'], ['edition' => $edition]) }}">
                      <img src="{{ $edition->cover() }}" class="img-responsive center-block">
                      <h5>{{ $edition->title() }}</h5>
                  </a>
              </div>
          @endforeach
      </div>
  @endforeach
</div>
@endauth
@endsection
