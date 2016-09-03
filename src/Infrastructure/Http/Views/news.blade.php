@extends('base-layout')

@section('sub-menu')
<ul class="nav navbar-nav navbar-center">
    <li><a href="/post">All</a></li>
    <li><a href="/news">News</a></li>
    <li><a href="/blog">Blog</a></li>
</ul>
@endsection

@section('content')

  @foreach ($posts as $post)
    <hr>
    <h2><a href="post/{{ $post->uuid }}">{{ $post->title }}</a> ({{ $post->type }})</h2>
    {{ $post->content }}
  @endforeach

  <!-- paginate -->
  <div style="text-align: center;">

  </div>

@endsection
