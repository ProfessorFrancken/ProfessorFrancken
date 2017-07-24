@extends('pages.association')
@inject('franckenVrij', "Francken\Application\FranckenVrij\FranckenVrijRepository")
@section('header-image-url', '/images/header/library-books.jpeg')
<?php
$volumes = $franckenVrij->volumes();
?>

@section('main-content')

    <div class="container">

    <div class="section-header d-inline-block mt-4 h1">
        Francken Vrij
    </div>

    <div class="row">
        <div class="col-md-12">
            <p>
                Francken Vrij is the popular science magazine of the Technisch Fysische Vereniging ‘Professor Francken’ and is distributed to its members, sponsors and other interested parties. The complete Francken Vrij archive can be found on this page.
            </p>
            <p>
                The theme of each edition is different but relates to (Applied) Physics. The contents of the magazine changes slightly from edition to edition but generaly one might expect an article by one of the applied physics research groups, an article by a student about his or her internship or a graduate about her or his new job.
                Most editions come with a challenging puzzle and a fun comic as well.
            </p>
        </div>
        <!-- <div class="col-md-4">
            <div class="well">
                <p>
                    Volutpat commodo sed egestas egestas fringilla phasellus faucibus scelerisque eleifend donec pretium vulputate sapien! Pretium aenean pharetra, magna ac placerat vestibulum, lectus mauris ultrices eros, in cursus turpis massa tincidunt?
                </p>
            </div>
        </div> -->
    </div>
    </div>

<div class="ribbon ribbon--light my-5">
    <div class="container">
        <h2 class="ribbon__header">
            The latest volume
        </h2>

        <div class="ribbon__items row align-items-stretch">

          @foreach(array_shift($volumes)->editions() as $edition)

              <article class="col-md-4 d-flex flex-column news-item">

                  <h4 class="news-item__title text-center">
                      {{ $edition->title() }}
                  </h4>
                  <div class="text-center">
                      <a href="{{ $edition->pdf() }}">
                          <img src="{{ $edition->cover() }}" class="img-responsive center-block">
                      </a>
                  </div>

                  <div class="text-center my-3">
                      <a href="{{ $edition->pdf() }}" class="btn btn-inverse">Download</a>
                  </div>
              </article>
          @endforeach
        </div>
    </div>
</div>

<div class="container">

  @foreach($volumes as $volume)

      <h2>Volume {{ $volume->volume() }}</h2>

      <div class="row">
          @foreach($volume->editions() as $edition)
              <div class="col-sm-4 text-center">
                  <a href="{{ $edition->pdf() }}">
                      <img src="{{ $edition->cover() }}" class="img-responsive center-block">
                      <h5>{{ $edition->title() }}</h5>
                  </a>
              </div>
          @endforeach
      </div>
  @endforeach
</div>
@endsection
