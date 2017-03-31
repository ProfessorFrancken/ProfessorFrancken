@extends('pages.association')

@section('content')
  <h1 class="section-header">
    Committees
  </h1>

  <div class="row">
      @foreach ($committees as $committee)
          @component('pages.association._committee')
          @slot('name')
          {{ $committee['title'] }}
          @endslot

          @slot('link')
          {{ $committee['link'] }}
          @endslot

          @slot('logo')
          {{ $committee['logo'] or '' }}
          @endslot
          @endcomponent
      @endforeach
  </div>
 @endsection
