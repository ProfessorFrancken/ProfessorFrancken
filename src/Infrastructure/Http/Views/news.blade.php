@extends('layouts.new')


@section('content')
  
  <!-- lelijk... -->
  <div style="height: 100px;"></div>

  <ol style="text-align: center;" class="breadcrumb">
    <li><a href="/post">All</a></li>
    <li><a href="/news">News</a></li>
    <li><a href="/blog">Blog</a></li>
  </ol>
  

  @foreach ($posts as $post)
    <h2><a href="post/{{ $post->uuid }}">{{ $post->title }}</a> ({{ $post->type }})</h2>
    {{ $post->content }}
  @endforeach

  <!-- paginate -->
  <div style="text-align: center;">
    {{ $posts->render() }}
  </div>

@endsection