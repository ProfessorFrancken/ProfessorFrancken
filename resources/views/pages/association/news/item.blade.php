@extends('layout.two-column-layout')

@section('title', $newsItem->title . " - T.F.V. 'Professor Francken'")
@section('description', $newsItem->exerpt)

@section('content')

    <h2 class="section-header">
        {{ $newsItem->title }}
    </h2>

    <span>
        Posted on {{ $newsItem->published_at->format('d M Y') }}
    </span>

    <hr>


    <div class="news-item__content justified-paragraphs">
        {!! $newsItem->compiled_contents !!}
    </div>

    <hr class="my-4">

    <div class="d-flex justify-content-between mb-5">
        @unless ($previous === null)
        <div class="d-flex flex-column">
            <strong>
                Previous news
            </strong>
            <a class="" href="{{ action([\Francken\Association\News\Http\NewsController::class, 'show'], ['news' => $previous]) }}">
                {{ $previous->title }}
            </a>
        </div>
        @endunless

        @unless ($next === null)
        {{-- Note: the latest news item does not have any next news item --}}
        <div class="d-flex flex-column text-right">
            <strong>
                Next news
            </strong>
            <a class="" href="{{ action([\Francken\Association\News\Http\NewsController::class, 'show'], ['news' => $next]) }}">
                {{ $next->title }}
            </a>
        </div>
        @endunless
    </div>

@endsection

@section('aside')
<div class="agenda">
    <h3 class="section-header agenda-header">
        Written by
    </h3>

    <ul class="agenda-list list-unstyled">
        <li class="agenda-item" style="margin-bottom: .5em; padding-bottom: .5em;">
            <div class="media align-items-center">
                <div class="media-body">
                    <h5 class="agenda-item__header">
                        {{ $newsItem->author_name }}
                    </h5>
                </div>
                <img
                    class="rounded d-flex ml-3"
                    src="{{image($newsItem->author_photo, ['height' => '75', 'width' => '75']) }}"
                    style="width: 75px; height: 75px; object-fit: cover; border-radius: 50%;"
                >
            </div>
        </li>
    </ul>
</div>
@endsection
