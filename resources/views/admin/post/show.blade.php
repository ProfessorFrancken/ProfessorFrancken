@extends('admin.layout')



@section('content')
  <h1 class="page-header">{{ $post->title }}</h1>

  {{ $post->content }}

@endsection
