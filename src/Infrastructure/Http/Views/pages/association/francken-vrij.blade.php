@extends('pages.association')

@section('content')

    <h1 class="centered-header">
        Francken Vrij
    </h1>

    <div class="row">
        <div class="col-md-8">
            <p>
                Francken Vrij is the popular science magazine of the Technisch Fysische Vereniging ‘Professor Francken’ and is distributed to its members, sponsors and other interested parties. The complete Francken Vrij archive can be found on this page.
            </p>
            <p>
                Quam nulla porttitor massa id neque aliquam vestibulum morbi blandit cursus risus, at ultrices mi tempus imperdiet nulla malesuada pellentesque elit eget gravida! Turpis in eu mi bibendum neque egestas.
            </p>
        </div>
        <div class="col-md-4">
            <div class="well">
                <p>
                    Volutpat commodo sed egestas egestas fringilla phasellus faucibus scelerisque eleifend donec pretium vulputate sapien! Pretium aenean pharetra, magna ac placerat vestibulum, lectus mauris ultrices eros, in cursus turpis massa tincidunt?
                </p>
            </div>
        </div>
    </div>

  @foreach(range(20, 1, -1) as $i)

    <hr class="thin-bar"/>

    <h2>Jaargang {{ $i }}</h2>

    <div class="row" style="text-align: center">
      <div class="col-sm-4">
          <a href="http://www.professorfrancken.nl/franckenvrij/{{ $i }}.1.pdf">
              <img src="http://www.professorfrancken.nl/franckenvrij/webplaatjes/{{ $i }}.1.jpg">
              <h5>Francken Vrij {{ $i }}.1</h5>
          </a>
      </div>
      <div class="col-sm-4">
          <a href="http://www.professorfrancken.nl/franckenvrij/{{ $i }}.2.pdf">
              <img src="http://www.professorfrancken.nl/franckenvrij/webplaatjes/{{ $i }}.2.jpg">
              <h5>Francken Vrij {{ $i }}.2</h5>
          </a>
      </div>
      <div class="col-sm-4">
          <a href="http://www.professorfrancken.nl/franckenvrij/{{ $i }}.3.pdf">
              <img src="http://www.professorfrancken.nl/franckenvrij/webplaatjes/{{ $i }}.3.jpg">
              <h5>Francken Vrij {{ $i }}.3</h5>
          </a>
      </div>
    </div>

  @endforeach

@endsection
