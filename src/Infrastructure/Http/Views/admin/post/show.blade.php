@extends('layouts.dashboard')



@section('content')
  <h1 class="page-header">{{ $post->title }}</h1>

  {{ $post->content }}

@endsection