@extends('layouts.dashboard')

@section('content')
  <h1 class="page-header">Posts</h1>
  
  <table class="table table-hover">
    <tr>
      <th>Title</th>
      <th>Content</th>
      <th>Published at</th>
    </tr>

    @foreach ($posts as $post)
      <tr onclick="window.document.location='{{ $post->uuid }}';">
        <td>{{ $post->title }}</td>
        <td>{{ $post->content }}</td>
        <td>{{ $post->published_at }}</td>
      </tr>
    @endforeach
  </table>

@endsection
