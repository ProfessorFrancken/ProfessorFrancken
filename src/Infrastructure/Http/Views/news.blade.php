@extends('layouts.new')


@section('content')
  
  <!-- lelijk... -->
  <div style="height: 100px;"></div>

  <ol style="text-align: center;" class="breadcrumb">
    <li class="active">All</li>
    <li><a href="/news/news">News</a></li>
    <li><a href="/news/blog">Blog</a></li>
  </ol>
  

  @foreach ($posts as $post)
    <h2><a href="news/{{ $post->uuid }}">{{ $post->title }}</a></h2>
    {{ $post->content }}
  @endforeach

  <div style="text-align: center;">
    {{ $posts->render() }}
  </div>

@endsection