@extends('layout.one-column-layout')
@section('header-image-url', '/images/header/library-books.jpeg')
@section('title', "Buy \"" . $book->title() . "\" - T.F.V. 'Professor Francken'")

@section('content')

    <div class="row">
  	    <div class="col col-sm-4">
  	        <img src="{{ $book->pathToCover() }}" class="img-fluid">
  	    </div>
        <div class="col col-sm-8">
            <h1 class="h3">
                {{ $book->title() }}
                <br/>
                <small>
                    Author: {{ $book->author() }}
                </small>
            </h1>

            <dl class="row">
                <dt class="col-2 col-md-1">
                    Price
                </dt>
                <dd class="col-10 col-md-11">
                    €{{ number_format($book->price()/100, 2, ",", "") }}
                </dd>

                <dt class="col-2 col-md-1">
                    ISBN
                </dt>
                <dd class="col-10 col-md-11">
                    {{ $book->isbn() }}
                </dd>
            </dl>

            <div class="alert alert-success">
                <p>
                    To buy this book come to the board room and tell one of the board  members that you're interested in buying this book. Or send them email to <a href="mailto:books@professorfrancken.nl">books@professorfrancken.nl</a>
                </p>
            </div>
        </div>
    </div>

@endsection
