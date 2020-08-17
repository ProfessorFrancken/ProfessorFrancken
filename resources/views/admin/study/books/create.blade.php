@extends('admin.layout')
@section('page-title', 'Books / Put a book on sale')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                {!! Form::model($book, ['url' => 'admin/study/books', 'method' => 'post']) !!}
                <div class="card-body">
                    <p class="lead">
                        Use the form below to add a new book to our database.
                        For your convenience you can use the search bar to search for books and automatically fill in all details.
                        Note that the edition number of the book is not filled in automatically.
                    </p>
                    <div class="mb-4">
                        <x-forms.text name="search" label="Search for books" placeholder="Search by title, author and / or isbn" />
                    </div>

                    @include('admin.study.books._form', ['book' => $book])
                </div>
                <div class="card-footer">
                    <x-forms.submit>Add book</x-forms.submit>
                </div>
                {!! Form::close() !!}
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
                      $('[name="title"]').val(ui.item.title);
                      $('[name="author"]').val(ui.item.author);
                      $('[name="isbn"]').val(ui.item.isbn[1].identifier);
                      $('[name="edition"]').val(ui.item.edition);
                      $('.book-image').attr("src", ui.item.image);
                  },
                  minLength: 3 // set minimum length of text the user must enter
              });
          });
    </script>
    @endpush
