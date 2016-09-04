@extends('pages.about')

@section('content')

  <h1>Francken Vrij</h1>

  <p>Francken Vrij is the popular science magazine of the Technisch Fysische Vereniging ‘Professor Francken’ and is distributed to its members, sponsors and other interested parties. The complete Francken Vrij archive can be found on this page.</p>

  @foreach(range(19, 1, -1) as $i)

    <hr>

    <h2>Jaargang {{ $i }}</h2>

    <div class="row" style="text-align: center">
      <div class="col-sm-4">
        <img src="http://www.professorfrancken.nl/franckenvrij/webplaatjes/{{ $i }}.1.jpg">
        <h5>Francken Vrij {{ $i }}.1</h5>
      </div>
      <div class="col-sm-4">
        <img src="http://www.professorfrancken.nl/franckenvrij/webplaatjes/{{ $i }}.2.jpg">
        <h5>Francken Vrij {{ $i }}.2</h5>
      </div>
      <div class="col-sm-4">
        <img src="http://www.professorfrancken.nl/franckenvrij/webplaatjes/{{ $i }}.3.jpg">
        <h5>Francken Vrij {{ $i }}.3</h5>
      </div>
    </div>

  @endforeach

@endsection
