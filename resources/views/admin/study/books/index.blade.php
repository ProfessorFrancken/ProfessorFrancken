@extends('admin.layout')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">

                    <h1 class="section-header">
                        Books
                    </h1>

                </div>
                <div class="card-body bg-light">

                    <p class="lead">
                        Use the form below to add a new book to our database. For your convenience you can use the search bar to search for books and automatically fill in all details. Note that the edition number of the book is not filled in automatically.

                    </p>

                    {!! Form::model($book, ['url' => 'admin/study/books', 'method' => 'post']) !!}
                        {!! Form::text('search', null, ['class' => 'form-control search-for-book', 'placeholder' => 'Search by title, author and / or isbn']) !!}

                    <div class="row mt-4">
                        <div class="col">
                            <div class="form-group">
                                <label for="title">Book title</label>
                                {!! Form::text('title', null, ['class' => 'form-control book-title', 'placeholder' => 'Title', 'id' => 'tilte']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::text('edition', null, ['class' => 'form-control book-edition', 'placeholder' => 'Edition']) !!}

                            </div>
                            <div class="form-group">
                                {!! Form::text('author', null, ['class' => 'form-control book-author', 'placeholder' => 'Author']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::text('isbn', null, ['class' => 'form-control book-isbn', 'placeholder' => 'Isbn']) !!}
                            </div>

                            <div class="form-group">
                                {{-- The seller field is used to autocomplete seller-id--}}
                                <label for="seller">Sold by member</label>
                                {!! Form::text('seller', null, ['class' => 'form-control book-seller', 'placeholder' => 'Seller', 'id' => 'seller']) !!}
                                {!! Form::hidden('seller-id', null, ['class' => 'book-seller-id']) !!}
                            </div>

                            <div class="form-group">
                                <label for="price">Price in euros</label>
                                {!! Form::number('price', 10, ['class' => 'form-control book-price', 'placeholder' => 'Price', 'id' => 'price']) !!}
                            </div>
                        </div>

                        <div class="col-md-3">
                            <img alt="" src="" class="book-image" />
                        </div>
                    </div>

                    {!! Form::submit('Add book', ['class' => 'btn btn-outline-success']) !!}

                    {!! Form::close() !!}
                </div>
                <div class="card-body">
                    <p class="lead">
                        The table below shows only books that are currently being sold.

                    </p>
                </div>


                @include('admin.study.books._table', ['books' => $books])
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
@endpush

@push('scripts')
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script type="text/javascript">
     var members = {!! json_encode($members) !!};

     // from https://www.librarieshacked.org/tutorials/autocompletewithapi
          $(document).ready(function () {
              $('.search-for-book').autocomplete({
                  // define source of the data
                  source: function (request, response) {
                      // url link to google books, including text entered by user (request.term)
                      var booksUrl = 'https://www.googleapis.com/books/v1/volumes?printType=books&q=' + encodeURIComponent(request.term);
                      $.ajax({
                          url: booksUrl,
                          dataType: 'jsonp',
                          success: function(data) {
                              response($.map(data.items, function (item) {
                                  if (item.volumeInfo.authors && item.volumeInfo.title
                                      && item.volumeInfo.industryIdentifiers && item.volumeInfo.publishedDate) {
                                      return {
                                          // label value will be shown in the suggestions
                                          label: item.volumeInfo.title + ', ' + item.volumeInfo.authors[0] + ', ' + item.volumeInfo.publishedDate,
                                          // value is what gets put in the textbox once an item selected
                                          value: item.volumeInfo.title,
                                          // other individual values to use later
                                          title: item.volumeInfo.title,
                                          author: item.volumeInfo.authors[0],
                                          isbn: item.volumeInfo.industryIdentifiers,
                                          publishedDate: item.volumeInfo.publishedDate,
                                          image: (item.volumeInfo.imageLinks == null ? '' : item.volumeInfo.imageLinks.thumbnail),
                                          description: item.volumeInfo.description
                                      };
                                  }
                              }));
                          }
                      });
                  },
                  select: function (event, ui) {
                      console.log(event, ui)
                      $('.book-title').val(ui.item.title);
                      $('.book-author').val(ui.item.author);
                      $('.book-isbn').val(ui.item.isbn[1].identifier);
                      $('.book-edition').val(ui.item.edition);
                      $('.book-image').attr("src", ui.item.image);
                  },
                  minLength: 3 // set minimum length of text the user must enter
              });

              var membersSource = members.map(function (member) {
                  return {
                      label: [member.voornaam, member.tussenvoegsel, member.achternaam].filter(function (val) { return val }).join(' '),
                      id: member.id
                  };
              });

              $('.book-seller').autocomplete({
                  source: membersSource,
                  select: function (event, ui) {
                      $('.book-seller-id').val(ui.item.id);
                  },
                  minLength: 2
              });
          });
    </script>
    @endpush
