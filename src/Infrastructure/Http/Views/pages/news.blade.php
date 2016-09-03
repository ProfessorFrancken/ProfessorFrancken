@extends('base-layout')

@section('sub-menu')
    @include('layout._subnavigation', [
        'list' => [
            ['url' => "/post", 'title' => 'All'],
            ['url' => "/news", 'title' => 'News'],
            ['url' => "/blog", 'title' => 'Blog'],
        ]
    ])
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
