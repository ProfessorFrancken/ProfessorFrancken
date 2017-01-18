@extends('admin.layout')

@section('content')
  <h1 class="page-header">Posts</h1>

  <table class="table table-hover">
    <tr>
      <th>Title</th>
      <th>Content</th>
      <th>Published at</th>
    </tr>

    @foreach ($posts as $post)
      <tr onclick="window.document.location='/admin/post/{{ $post->id }}';">
        <td>{{ $post->title }}</td>
        <td>{{ $post->content }}</td>
        <td>{{ $post->publishedAt }}</td>
      </tr>
    @endforeach
  </table>

@endsection
