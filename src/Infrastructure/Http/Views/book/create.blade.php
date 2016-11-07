@extends('base-layout')


@section('content')

  <h1>Sell your books here</h1>
  <hr>
  <p>
    Simply enter the ISBN and the price.
  </p>


  <div class="row">
    <div class="col-sm-7">
      {!! Form::open(['url' => 'study/books']) !!}
        @include('book._book')
      {!! Form::close() !!}
    </div>

    <div class="col-sm-5">
      <img alt="Book not found" style="width: 100%" id="book-cover" src="...">
    </div>
  </div>

@endsection


@section('scripts')

<script type="text/javascript">
$(function(){
  // $("#book-cover").attr("src", "http://images.amazon.com/images/P/0534408133.jpg");
});
</script>

@endsection
