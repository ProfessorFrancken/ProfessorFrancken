@extends('layout.one-column-layout')

@section('title', $album->title . " - Photos - T.F.V. 'Professor Francken'")
@section('description', $album->description)

@section('content')
    <ul class="list-unstyled d-flex justify-content-center align-items-center">
        <li class="col d-none d-md-block text-left font-weight-bold" style="flex-grow: 1; flex-basis:0">
            @isset($previous_album)
            <a href="{{ $previous_album->url() }}">
                Previous album<br/>
                <u>{{ $previous_album->title }}</u>
            </a>
            @endisset
        </li>
        <li style="flex-grow: 1; flex-basis:0">
            <h1 class="section-header section-header--centered mb-3">
                {{ $album->title }}
            </h1>

            <h3 class="text-center mb-4">
                {{ $album->published_at->format('Y-m-d') }}
            </h3>
        </li>
        <li class="d-none d-md-block text-right font-weight-bold" style="flex-grow: 1; flex-basis:0">
            @isset($next_album)
            <a href="{{ $next_album->url() }}">
                Next album<br/>
                <u>{{ $next_album->title }}</u>
            </a>
            @endisset
        </li>
    </ul>

    <p class="lead">
        {{ $album->description }}
    </p>

    <ul class="list-unstyled photo-grid">
        @if ($photos->onFirstPage())
            @include('association.photos._photo', ['photo' => $cover_photo, 'classes' => ['photo-cover']])
        @endif

        @foreach ($photos as $photo)
            @include('association.photos._photo', ['photo' => $photo])
        @endforeach
    </ul>

    {{ $photos->links()  }}

    <hr class="my-4"/>

    <h3 class="my-3">Other albums you might like</h3>

    <ul class="list-unstyled photo-grid">
        @isset($previous_album)
            @include('association.photos._album', ['album' => $previous_album])
        @endisset

        @isset($next_album)
            @include('association.photos._album', ['album' => $next_album])
        @endisset
    </ul>
@endsection
