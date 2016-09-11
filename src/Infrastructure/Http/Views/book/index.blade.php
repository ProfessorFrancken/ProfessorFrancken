@extends('base-layout')


@section('content')

  <div class="jumbotron">
    <h1>Second hand books</h1>
    <p>
      On this page you will find all second hand books that are for sale at Francken. If you’re intersted in buying a book you can just come to the boardroom and pick up your books. The fee will be taken from your bankaccount with the next depreciation.
    </p>

    <p>
      Questions? mail: <a href="mailto:books@professorfrancken.nl">books@professorfrancken.nl</a>
    </p>

    <p><a class="btn btn-primary btn-lg" href="/book/create" role="button">Sell your books!</a></p>
  </div>

  <div class="row">

    @foreach($books as $book)
    <div class="col-xs-6 col-sm-4 col-md-3">
      <div class="thumbnail">
        <img src="{{ $book->pathToCover() }}" alt="...">
        <div class="caption">
          <h3>{{ $book->title() }}</h3>
          <p>{{ $book->author()  }}</p>
          <p>€{{ number_format($book->price()/100, 2, ",", "") }} <a class="btn btn-primary" href="/book/{{ $book->bookId() }}">Buy!</a></p>
        </div>
      </div>
    </div>
    @endforeach


  </div>


@endsection
