@extends('base-layout')


@section('content')

  <h1>{{ $book->title() }}</h1>

  <div class="row">
  	<div class="col-sm-4">
  	  <img src="{{ $book->pathToCover() }}" width="100%">
  	</div>
    <div class="col-sm-8">
      <h2>{{ $book->title() }}</h2>
      <h3>{{ $book->author()  }}</h3>
      <p>Price: €{{ number_format($book->price()/100, 2, ",", "") }}</p>
      {!! Form::open(['url' => ['books', $book->bookId(), 'buy'], 'method' => 'PUT']) !!}
	    {!! Form::submit('Buy!', ['class' => 'btn btn-primary']) !!}
      {!! Form::close() !!}
    </div>
  </div>

@endsection
