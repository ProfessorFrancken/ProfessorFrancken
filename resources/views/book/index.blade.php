@extends('homepage.one-column-layout')
@section('title', "Books - T.F.V. 'Professor Francken'")
@section('description', "Buy or sell second hand study books.")
@section('header-image-url', '/images/header/library-books.jpeg')

@section('content')
    <div class="jumbotron py-5">
        <h1 class="section-header">Second hand books</h1>
        <p>
            On this page you will find all second hand books that are for sale at Francken. If you’re intersted in buying a book you can just come to the boardroom and pick up your books. The fee will be taken from your bankaccount with the next depreciation.
        </p>

        <p>
            Questions? mail: <a href="mailto:books@professorfrancken.nl">books@professorfrancken.nl</a>
        </p>

        <h2>Selling your books?</h2>
        <p>
            That’s also possible! Bring your books to the boardroom and determine your price. All money goes to the seller, so Francken won’t make money on it.
        </p>
    </div>

    <div class="ribbon__items row no-gutters align-items-stretch my-5">
        @foreach ($books as $book)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3" style="border-bottom: thin solid #eee; border-top: thin solid #eee;">
                <article class="h-100 preview-item d-flex flex-column justify-content-between">
                    <div>
                        <img src="{{ image($book->pathToCover(), ['height' => 300, 'width' => 220]) }}" alt="Cover of {{ $book->title() }}" class="img-fluid mb-2" style="height: 300px;">
                        <h3 class="h5">
                            {{ $book->title() }}
                            <br/>
                            <small class="text-muted">
                                {{ $book->author() }}
                            </small>
                        </h3>
                        <p class="text-muted">
                            ISBN: {{ $book->isbn() }}
                        </p>
                    </div>

                    <div>
                        <a href="/study/books/{{ $book->bookId() }}" class="btn btn-outline-primary btn-block">
                            Buy for €{{ number_format($book->price()/100, 2, ",", "") }}
                        </a>
                    </div>
                </article>
            </div>
        @endforeach
    </div>
@endsection
