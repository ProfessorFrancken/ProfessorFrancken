@extends('study.research-groups.index')
@section('title', $group['title'] . " - Research Groups - T.F.V. 'Professor Francken'")
@section('header-image-url', $group['photo'])

@section('content')
    <div class="section-header d-inline-block mt-4 h1">
        {{  $group['title']}}
    </div>
    <div class="row mt-2">

          <div class="col text-justify">
                {!! $group['description'] !!}
          </div>
    </div>
    <br>
    <div class="row">
          @foreach($group['groups'] as $unit)
                <div class="col-md-6 mt-3">
                      <img src="{{ image($unit['foto'], ['width' => 283, 'height' => 142]) }}" width="283" height="142" class="rounded">
                        <h2> {{ $unit['group'] }} Group</h2>
                      {{ $unit['title'] }}
                      <br>
                      <a class="btn btn-secondary" href="{{ $unit['contact'] }}">
                            Contact
                      </a>
                      <a class="btn btn-info" href="{{ $unit['link'] }}">
                            Group Info
                      </a>
                </div>
          @endforeach
    </div>
    <br><br><br>
@endsection
