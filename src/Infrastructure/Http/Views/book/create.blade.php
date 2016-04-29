@extends('layouts.basic')


@section('content')

  <div class="row">
    <div class="col-8-sm">
      {!! Form::open(['url' => 'book']) !!}
        @include('book._book');
      {!! Form::close() !!}
    </div>

    <div class="col-4-sm">
      <div id="book-cover">

      </div>
    </div>
  </div>

@endsection
